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
        Schema::table('shops', function (Blueprint $table) {
            // Χρώματα
            $table->string('primary_color')->default('#4c1d95'); // Το μωβ από το image_2.png ως default
            $table->string('accent_color')->default('#2dd4bf'); // Το γαλάζιο/teal από το image_2.png ως default

            // Λογότυπο (αποθηκεύουμε το path του αρχείου)
            $table->string('logo_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            //
        });
    }
};
