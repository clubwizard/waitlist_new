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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index(); // Index for faster lookups
            $table->string('phone')->index(); // Index for faster lookups
            $table->text('notes')->nullable();
            $table->boolean('marketing_opt_in')->default(false);
            $table->json('preferences')->nullable(); // Store seating_preferences, dietary_restrictions, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
