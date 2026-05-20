<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('imagekit_file_id')->nullable();
            $table->text('imagekit_url')->nullable();
            $table->boolean('uploaded_to_imagekit')->default(0);
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->string('imagekit_file_id')->nullable();
            $table->text('imagekit_url')->nullable();
            $table->boolean('uploaded_to_imagekit')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['imagekit_file_id', 'imagekit_url', 'uploaded_to_imagekit']);
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropColumn(['imagekit_file_id', 'imagekit_url', 'uploaded_to_imagekit']);
        });
    }
};
