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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->string('user_name');
            $table->string('email')->nullable();
            $table->integer('rating')->default(5);
            $table->string('video_url')->nullable();
            $table->string('review_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_checked')->default(true);
            $table->boolean('client_created')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
