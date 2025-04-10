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
        Schema::create('api_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->enum('service', ['twilio', 'sendgrid', 'airship', 'piggy', 'google_maps', 'collins', 'sevenrooms', 'resdiary', 'leat', 'como', 'opentable']); // Added more from notes
            $table->json('credentials'); // Store API keys, tokens, etc. securely
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->unique(['restaurant_id', 'service']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_credentials');
    }
};
