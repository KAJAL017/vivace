<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Banners table mein responsive image columns add karo:
     * - desktop: 1920x600 (original / large)
     * - tablet:  1024x400
     * - mobile:  768x300
     * Sab WebP format mein ImageKit se serve honge
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Desktop size (1920px wide)
            $table->text('imagekit_url_desktop')->nullable()->after('imagekit_url');
            // Tablet size (1024px wide)
            $table->text('imagekit_url_tablet')->nullable()->after('imagekit_url_desktop');
            // Mobile size (768px wide)
            $table->text('imagekit_url_mobile')->nullable()->after('imagekit_url_tablet');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['imagekit_url_desktop', 'imagekit_url_tablet', 'imagekit_url_mobile']);
        });
    }
};
