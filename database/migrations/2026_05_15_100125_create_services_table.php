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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Π.χ. Ανδρικό Κούρεμα
            $table->integer('price'); // Τιμή σε λεπτά (π.χ. 1500 για 15€ - είναι Senior πρακτική για να αποφεύγεις λάθη με δεκαδικά)
            $table->integer('duration_minutes'); // Πόση ώρα διαρκεί
            
            // Σύνδεση με το μαγαζί
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete(); // shop_id υπηρεσίας
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
