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
        Schema::create('waitlist_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index(); // Allow null for public entries
            $table->string('name'); // Customer name at time of entry
            $table->string('email')->nullable(); // Customer email at time of entry
            $table->string('phone_number'); // Customer phone at time of entry
            $table->integer('party_size');
            $table->enum('status', ['pending', 'notified', 'seated', 'cancelled', 'no_show'])->default('pending')->index();
            $table->integer('position')->nullable(); // Position in the queue
            $table->integer('estimated_wait_time')->nullable(); // In minutes
            $table->integer('quoted_wait_time')->nullable(); // In minutes
            $table->text('notes')->nullable();
            $table->string('table_number')->nullable();
            $table->json('metadata')->nullable(); // Store allergies, special_requests, etc.
            $table->timestamp('notified_at')->nullable();
            $table->timestamp('seated_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Staff member who added/seated
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist_entries');
    }
};
