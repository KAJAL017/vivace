<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('google_analytics_id', 50)->nullable()->after('cod_enabled');
            $table->string('google_analytics_api_key', 255)->nullable()->after('google_analytics_id');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['google_analytics_id', 'google_analytics_api_key']);
        });
    }
};