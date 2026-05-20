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
        // Add is_active to categories
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->after('is_deleted');
        });
        
        // Add is_active to sub_categories
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->after('is_deleted');
        });
        
        // Add is_active to collections
        Schema::table('collections', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->after('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
