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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Στοιχεία Πελάτη (για αρχή τα κρατάμε απλά)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('notes')->nullable();
        
            // Συνδέσεις
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            
            // Χρόνος
            $table->dateTime('start_time');
            $table->dateTime('finish_time');
            
            // Κατάσταση (π.χ. Pending, Confirmed, Canceled)
            $table->string('status')->default('confirmed');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
