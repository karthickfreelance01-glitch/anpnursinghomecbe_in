<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Shared columns for the two "landing page" content types
        $landing = function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('icon', 60)->nullable();              // bootstrap-icons class, e.g. bi-heart-pulse
            $t->string('tagline')->nullable();
            $t->text('short_description')->nullable();
            $t->longText('description')->nullable();         // HTML
            $t->json('services')->nullable();                // ["..", ".."]
            $t->json('faqs')->nullable();                    // [{q:..,a:..}]
            $t->string('image')->nullable();                 // card image (path relative to /public)
            $t->string('banner_image')->nullable();          // landing page hero image
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->string('meta_title')->nullable();
            $t->string('meta_description', 500)->nullable();
            $t->string('meta_keywords', 500)->nullable();
            $t->string('og_image')->nullable();
        };

        Schema::create('departments', function (Blueprint $t) use ($landing) {
            $landing($t);
            $t->boolean('show_in_menu')->default(true);
            $t->timestamps();
        });

        Schema::create('specialities', function (Blueprint $t) use ($landing) {
            $landing($t);
            $t->string('category', 20)->index();            // medical | surgical
            $t->timestamps();
        });

        Schema::create('banners', function (Blueprint $t) {
            $t->id();
            $t->string('title')->nullable();
            $t->string('image');
            $t->string('mobile_image')->nullable();
            $t->string('alt')->nullable();
            $t->string('link')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('phone', 30);
            $t->string('email')->nullable();
            $t->string('department')->nullable();
            $t->date('preferred_date')->nullable();
            $t->text('message')->nullable();
            $t->string('source')->nullable();               // page the form was sent from
            $t->string('status', 20)->default('new')->index(); // new | contacted | closed
            $t->text('admin_note')->nullable();
            $t->string('ip', 45)->nullable();
            $t->string('user_agent', 500)->nullable();
            $t->timestamps();
        });

        Schema::create('seo_pages', function (Blueprint $t) {
            $t->id();
            $t->string('page_key')->unique();               // home, about, departments ...
            $t->string('label');
            $t->string('meta_title')->nullable();
            $t->string('meta_description', 500)->nullable();
            $t->string('meta_keywords', 500)->nullable();
            $t->string('og_image')->nullable();
            $t->string('canonical')->nullable();
            $t->boolean('noindex')->default(false);
            $t->timestamps();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['settings', 'seo_pages', 'enquiries', 'banners', 'specialities', 'departments'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
