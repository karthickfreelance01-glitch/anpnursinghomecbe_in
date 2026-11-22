<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Department;
use App\Models\SeoPage;
use App\Models\Setting;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Safe to run more than once: existing rows are never overwritten,
 * so edits made in the admin panel are kept.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin login -------------------------------------------------
        User::firstOrCreate(
            ['email' => 'admin@anpnursinghomecbe.in'],
            ['name' => 'ANP Admin', 'password' => Hash::make('Anp@12345')]
        );

        // ---- Hero banners ------------------------------------------------
        if (Banner::count() === 0) {
            foreach (config('anp.hero_slides') as $i => $s) {
                Banner::create([
                    'title'      => $s['alt'],
                    'alt'        => $s['alt'],
                    'image'      => 'assets/img/hero/' . $s['img'],
                    'sort_order' => $i + 1,
                ]);
            }
        }

        // ---- Departments -------------------------------------------------
        foreach (require __DIR__ . '/data/departments.php' as $i => $d) {
            Department::firstOrCreate(['slug' => $d['slug']], [
                'name'              => $d['name'],
                'icon'              => $d['icon'],
                'tagline'           => $d['tagline'],
                'short_description' => $d['short'],
                'description'       => $this->paragraphs($d['overview']),
                'services'          => $d['services'],
                'faqs'              => $d['faqs'],
                'image'             => $d['image'],
                'sort_order'        => $i + 1,
                'meta_title'        => $d['name'] . ' in Coimbatore | ANP Nursing Home',
                'meta_description'  => $d['short'],
                'meta_keywords'     => strtolower($d['name']) . ' coimbatore, best ' . strtolower($d['name']) . ' hospital coimbatore, anp nursing home',
            ]);
        }

        // ---- Medical / Surgical specialities -----------------------------
        foreach (require __DIR__ . '/data/specialities.php' as $category => $items) {
            foreach ($items as $i => [$slug, $name, $icon, $short, $services]) {
                $label = $category === 'medical' ? 'medical' : 'surgical';
                Speciality::firstOrCreate(['slug' => $slug], [
                    'category'          => $category,
                    'name'              => $name,
                    'icon'              => $icon,
                    'tagline'           => ucfirst($label) . ' speciality care in Coimbatore',
                    'short_description' => $short,
                    'description'       => $this->paragraphs([
                        $short,
                        "At ANP Nursing Home, {$name} patients are supported by our in-house laboratory, pharmacy, imaging, operation theatres and 24×7 ICU, so evaluation, treatment and follow-up happen under one roof. Visiting consultants are available as per the schedule — please call us to confirm the doctor's timings before your visit.",
                    ]),
                    'services'          => $services,
                    'faqs'              => [
                        ['q' => "How do I book a {$name} consultation?", 'a' => 'Use the appointment form on this page or call +91 88707 77516. Our front desk will confirm your slot.'],
                        ['q' => 'Are the specialist doctors available every day?', 'a' => 'Some specialists visit on scheduled days only. Please check the doctor timings or call us before your visit.'],
                    ],
                    'image'             => file_exists(public_path("assets/img/specialities/{$slug}.webp")) ? "assets/img/specialities/{$slug}.webp" : null,
                    'sort_order'        => $i + 1,
                    'meta_title'        => "{$name} in Coimbatore | ANP Nursing Home",
                    'meta_description'  => $short,
                    'meta_keywords'     => strtolower($name) . ' coimbatore, ' . strtolower($name) . ' hospital thondamuthur road, anp nursing home',
                ]);
            }
        }

        // ---- Page SEO ----------------------------------------------------
        $pages = [
            'home'                => ['Home', 'Best Diabetologist & Multi Speciality Hospital in Coimbatore | ANP Nursing Home', 'ANP Nursing Home – NABH pre-accredited multi speciality hospital on Thondamuthur Road, Coimbatore. 24/7 emergency & ICU, diabetology, obstetrics & gynaecology, pharmacy and lab.', 'best diabetologist in coimbatore, multi speciality hospital coimbatore, hospital thondamuthur road, anp nursing home, 24/7 emergency hospital coimbatore'],
            'about'               => ['About Us', 'About ANP Nursing Home | 14+ Years of Trusted Care in Coimbatore', 'Learn about ANP Nursing Home, our doctors, vision and mission – compassionate and affordable healthcare in Coimbatore for over 14 years.', 'about anp nursing home, dr k arul, dr r nallichandra, hospital in coimbatore'],
            'departments'         => ['Departments', 'Departments & Specialities | ANP Nursing Home Coimbatore', 'Explore all departments at ANP Nursing Home – general medicine, diabetology, critical care, obstetrics, gynaecology, nephrology and 30+ medical & surgical specialities.', 'hospital departments coimbatore, medical speciality, surgical speciality'],
            'specialities.medical'  => ['Medical Speciality', 'Medical Specialities | ANP Nursing Home Coimbatore', 'Cardiology, diabetology, neurology, pulmonology, paediatrics and more medical specialities at ANP Nursing Home, Coimbatore.', 'medical speciality hospital coimbatore'],
            'specialities.surgical' => ['Surgical Speciality', 'Surgical Specialities | ANP Nursing Home Coimbatore', 'General, laparoscopic, ortho, neuro, urology and more surgical specialities with modern operation theatres at ANP Nursing Home, Coimbatore.', 'surgical speciality hospital coimbatore, laparoscopic surgery coimbatore'],
            'facilities'          => ['Facilities', 'Hospital Facilities – ICU, CT, Dialysis, Lab & Pharmacy | ANP Nursing Home', '24×7 ICU, ambulance, CT scan, dialysis, echo, lab, pharmacy, operation theatre and more facilities at ANP Nursing Home, Coimbatore.', 'icu coimbatore, dialysis coimbatore, ct scan thondamuthur road'],
            'health-checkup'      => ['Master Health Checkup', 'Master Health Checkup Packages in Coimbatore | ANP Nursing Home', 'Affordable diabetic, cardiac and general master health checkup packages with expert evaluation at ANP Nursing Home, Coimbatore.', 'master health checkup coimbatore, full body checkup coimbatore'],
            'contact'             => ['Contact Us', 'Contact ANP Nursing Home | Book Appointment Coimbatore', 'Call +91 88707 77516 or visit 8/1 Jaya Nagar, Poochiyur, Thondamuthur Road, Coimbatore – 641109. 24/7 emergency: +91 88707 83938.', 'anp nursing home contact, book appointment coimbatore hospital'],
        ];
        foreach ($pages as $key => [$label, $title, $desc, $kw]) {
            SeoPage::firstOrCreate(['page_key' => $key], [
                'label' => $label, 'meta_title' => $title, 'meta_description' => $desc, 'meta_keywords' => $kw,
            ]);
        }

        // ---- Global SEO settings ----------------------------------------
        foreach ([
            'site_name'        => 'ANP Nursing Home',
            'default_og_image' => 'assets/img/misc/hospital-building.webp',
            'title_suffix'     => 'ANP Nursing Home',
        ] as $k => $v) {
            Setting::firstOrCreate(['key' => $k], ['value' => $v]);
        }
        cache()->forget('anp.settings');
    }

    private function paragraphs(array $ps): string
    {
        return collect($ps)->map(fn ($p) => '<p>' . e($p) . '</p>')->implode("\n");
    }
}
