<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('imagekit_file_id', 255)->nullable()->after('image_path');
            $table->text('imagekit_url')->nullable()->after('imagekit_file_id');
            $table->text('imagekit_url_desktop')->nullable()->after('imagekit_url');
            $table->text('imagekit_url_tablet')->nullable()->after('imagekit_url_desktop');
            $table->text('imagekit_url_mobile')->nullable()->after('imagekit_url_tablet');
            $table->tinyInteger('uploaded_to_imagekit')->default(0)->after('imagekit_url_mobile');
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn([
                'imagekit_file_id',
                'imagekit_url',
                'imagekit_url_desktop',
                'imagekit_url_tablet',
                'imagekit_url_mobile',
                'uploaded_to_imagekit',
            ]);
        });
    }
};
