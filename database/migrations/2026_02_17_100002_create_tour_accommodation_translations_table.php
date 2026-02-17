<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_accommodation_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_accommodation_id')->constrained()->onDelete('cascade');
            $table->string('lang_code', 5);
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_accommodation_translations');
    }
};
