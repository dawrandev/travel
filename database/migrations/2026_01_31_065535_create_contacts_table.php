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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('telegram_url');
            $table->string('telegram_username');
            $table->string('instagram_username');
            $table->string('instagram_url');
            $table->string('facebook_name');
            $table->string('facebook_url');
            $table->string('youtube_url');
            $table->string('whatsapp_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
