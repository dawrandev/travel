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
        Schema::table('questions', function (Blueprint $table) {
            // Rename phone to whatsapp_phone
            $table->renameColumn('phone', 'whatsapp_phone');

            // Add region column after whatsapp_phone
            $table->string('region')->nullable()->after('whatsapp_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Remove region column
            $table->dropColumn('region');

            // Rename whatsapp_phone back to phone
            $table->renameColumn('whatsapp_phone', 'phone');
        });
    }
};
