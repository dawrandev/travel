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
        Schema::create('hero_slide_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_slide_id')->constrained('hero_slides')->onDelete('cascade');
            $table->string('title');
            $table->string('subtitle');
            $table->text('description')->nullable();
            $table->string('lang_code', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slide_translations');
    }
};
