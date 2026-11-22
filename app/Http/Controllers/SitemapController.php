<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Speciality;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            [route('home'), '1.0', 'weekly', null],
            [route('about'), '0.7', 'monthly', null],
            [route('departments'), '0.9', 'weekly', null],
            [route('specialities.category', 'medical'), '0.8', 'weekly', null],
            [route('specialities.category', 'surgical'), '0.8', 'weekly', null],
            [route('facilities'), '0.7', 'monthly', null],
            [route('health-checkup'), '0.8', 'monthly', null],
            [route('contact'), '0.7', 'yearly', null],
        ]);

        foreach (Department::active()->ordered()->get() as $d) {
            $urls->push([route('departments.show', $d->slug), '0.8', 'monthly', $d->updated_at]);
        }
        foreach (Speciality::active()->ordered()->get() as $s) {
            $urls->push([route('specialities.show', $s->slug), '0.7', 'monthly', $s->updated_at]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$loc, $priority, $freq, $mod]) {
            $xml .= '  <url><loc>' . e($loc) . '</loc>'
                . ($mod ? '<lastmod>' . $mod->toAtomString() . '</lastmod>' : '')
                . "<changefreq>{$freq}</changefreq><priority>{$priority}</priority></url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $body = "User-agent: *\nDisallow: /admin\nAllow: /\n\nSitemap: " . route('sitemap') . "\n";

        return response($body, 200, ['Content-Type' => 'text/plain']);
    }
}
