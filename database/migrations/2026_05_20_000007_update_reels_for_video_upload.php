<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            // reel_url optional banao (video upload ke liye)
            $table->text('reel_url')->nullable()->change();
            // ImageKit video URL
            $table->text('video_url')->nullable()->after('reel_url');
            $table->string('imagekit_file_id_video', 255)->nullable()->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'imagekit_file_id_video']);
        });
    }
};
