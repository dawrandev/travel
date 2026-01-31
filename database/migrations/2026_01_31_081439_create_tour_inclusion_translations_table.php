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
        Schema::create('tour_inclusion_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_inclusion_id')->constrained()->onDelete('cascade');
            $table->string('lang_code', 10);
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_inclusion_translations');
    }
};
