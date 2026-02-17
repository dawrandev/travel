<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('award_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_id')->constrained('awards')->onDelete('cascade');
            $table->string('lang_code');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('award_translations');
    }
};
