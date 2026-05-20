<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('reel_url');                          // FB / Instagram / YouTube reel URL
            $table->string('platform', 20)->default('other'); // instagram | facebook | youtube | other
            $table->unsignedBigInteger('product_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
