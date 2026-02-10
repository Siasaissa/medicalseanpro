<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table (patient)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign key to doctors table (or users table if doctors are also users)
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            

            // Booking details
            $table->string('service'); // e.g., "20 minutes"
            $table->decimal('service_price', 10, 2)->default(0);
            $table->string('appointment_type'); // e.g., "video"
            $table->dateTime('appointment_datetime');
            
            // Payment info
            $table->decimal('fees', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
