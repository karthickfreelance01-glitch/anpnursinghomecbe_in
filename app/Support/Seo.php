<?php

namespace App\Support;

use App\Models\SeoPage;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Builds every <head> SEO value (title, description, keywords, canonical,
 * Open Graph, Twitter, JSON-LD) from the database, with safe fallbacks.
 */
class Seo
{
    /** SEO for a static page stored in seo_pages (Admin → SEO). */
    public static function page(string $key, array $fallback = [], array $breadcrumbs = []): array
    {
        $row = null;
        try { $row = SeoPage::where('page_key', $key)->first(); } catch (\Throwable $e) {}

        return static::make([
            'title'       => $row->meta_title ?? $fallback['title'] ?? null,
            'description' => $row->meta_description ?? $fallback['description'] ?? null,
            'keywords'    => $row->meta_keywords ?? $fallback['keywords'] ?? null,
            'image'       => $row->og_image ?? $fallback['image'] ?? null,
            'canonical'   => $row->canonical ?? null,
            'noindex'     => (bool) ($row->noindex ?? false),
        ], $breadcrumbs);
    }

    /** SEO for a Department / Speciality landing page. */
    public static function landing(Model $item, array $breadcrumbs, string $schemaType = 'MedicalSpecialty'): array
    {
        $seo = static::make([
            'title'       => $item->meta_title ?: $item->name . ' in Coimbatore',
            'description' => $item->meta_description ?: Str::limit(strip_tags($item->short_description ?: $item->description), 158),
            'keywords'    => $item->meta_keywords,
            'image'       => $item->og_image ?: $item->banner_image ?: $item->image,
            'type'        => 'article',
        ], $breadcrumbs);

        $page = [
            '@context'    => 'https://schema.org',
            '@type'       => 'MedicalWebPage',
            'name'        => $item->name,
            'url'         => url()->current(),
            'description' => $seo['description'],
            'about'       => ['@type' => 'MedicalSpecialty', 'name' => $item->name],
            'publisher'   => ['@id' => url('/') . '#hospital'],
        ];
        $seo['schema'][] = $page;

        if (! empty($item->faqs)) {
            $seo['schema'][] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => collect($item->faqs)->filter(fn ($f) => ! empty($f['q']) && ! empty($f['a']))->values()->map(fn ($f) => [
                    '@type'          => 'Question',
                    'name'           => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ])->all(),
            ];
        }

        return $seo;
    }

    public static function make(array $v, array $breadcrumbs = []): array
    {
        $site   = Setting::get('site_name', config('anp.name'));
        $suffix = Setting::get('title_suffix', $site);
        $title  = $v['title'] ?: $site;
        if ($suffix && ! Str::contains($title, $suffix)) {
            $title .= ' | ' . $suffix;
        }

        $seo = [
            'title'       => $title,
            'description' => $v['description'] ?: Setting::get('default_description', 'ANP Nursing Home – Multi Speciality Hospital on Thondamuthur Road, Coimbatore.'),
            'keywords'    => $v['keywords'] ?? Setting::get('default_keywords'),
            'image'       => Asset::url($v['image'] ?? null) ?: Asset::url(Setting::get('default_og_image', 'assets/img/misc/hospital-building.webp')),
            'canonical'   => $v['canonical'] ?? null ?: url()->current(),
            'robots'      => ! empty($v['noindex']) ? 'noindex, nofollow' : 'index, follow, max-image-preview:large',
            'type'        => $v['type'] ?? 'website',
            'site_name'   => $site,
            'schema'      => [static::organization()],
        ];

        if ($breadcrumbs) {
            $list = [['Home', url('/')]];
            foreach ($breadcrumbs as $label => $link) $list[] = [$label, $link ?: url()->current()];
            $seo['schema'][] = [
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => collect($list)->values()->map(fn ($b, $i) => [
                    '@type' => 'ListItem', 'position' => $i + 1, 'name' => $b[0], 'item' => $b[1],
                ])->all(),
            ];
        }

        return $seo;
    }

    /** Hospital / MedicalOrganization schema – printed on every page. */
    public static function organization(): array
    {
        $c = config('anp.contact');

        return [
            '@context'   => 'https://schema.org',
            '@type'      => ['Hospital', 'MedicalOrganization'],
            '@id'        => url('/') . '#hospital',
            'name'       => Setting::get('site_name', config('anp.name')),
            'url'        => url('/'),
            'logo'       => asset('assets/img/misc/logo-mark.webp'),
            'image'      => asset('assets/img/misc/hospital-building.webp'),
            'telephone'  => $c['phone_raw'],
            'email'      => $c['email'],
            'priceRange' => '₹₹',
            'address'    => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '8/1 Jaya Nagar, Poochiyur, Thondamuthur Road, Dheenampalayam (PO)',
                'addressLocality' => 'Coimbatore',
                'addressRegion'   => 'Tamil Nadu',
                'postalCode'      => '641109',
                'addressCountry'  => 'IN',
            ],
            'openingHours'           => 'Mo-Su 00:00-23:59',
            'isAcceptingNewPatients' => true,
            'contactPoint'           => [[
                '@type' => 'ContactPoint', 'telephone' => $c['emergency_raw'], 'contactType' => 'emergency', 'areaServed' => 'IN',
            ]],
            'sameAs' => array_values(array_filter(config('anp.social'), fn ($u) => $u && $u !== '#')),
        ];
    }
}
