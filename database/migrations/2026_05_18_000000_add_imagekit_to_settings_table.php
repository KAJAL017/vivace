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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('imagekit_public_key')->nullable();
            $table->string('imagekit_private_key')->nullable();
            $table->string('imagekit_url_endpoint')->nullable();
            $table->boolean('imagekit_enabled')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['imagekit_public_key', 'imagekit_private_key', 'imagekit_url_endpoint', 'imagekit_enabled']);
        });
    }
};
