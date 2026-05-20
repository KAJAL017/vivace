<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['banner_table_1', 'banner_table_2', 'banner_table_3', 'banner_table_4'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('imagekit_file_id', 255)->nullable()->after('banner');
                    $table->text('imagekit_url')->nullable()->after('imagekit_file_id');
                    $table->boolean('uploaded_to_imagekit')->default(false)->after('imagekit_url');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['banner_table_1', 'banner_table_2', 'banner_table_3', 'banner_table_4'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn(['imagekit_file_id', 'imagekit_url', 'uploaded_to_imagekit']);
                });
            }
        }
    }
};
