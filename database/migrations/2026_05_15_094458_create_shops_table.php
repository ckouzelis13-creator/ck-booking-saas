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
        Schema::create('shops', function (Blueprint $table) {
            $table->id(); // id magaziou
            $table->string('name'); // onoma magaziou
            $table->string('slug')->unique(); // slug magaziou
            $table->string('address')->nullable(); //   address magaziou
            $table->string('phone')->nullable(); // phone magaziou
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // user_id magaziou
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
