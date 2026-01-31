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
        Schema::create('tour_itinerary_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_itenerary_id')->constrained('tour_itineraries')->onDelete('cascade');
            $table->string('lang_code', 5);
            $table->string('activity_title');
            $table->text('activity_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_itinerary_translations');
    }
};
