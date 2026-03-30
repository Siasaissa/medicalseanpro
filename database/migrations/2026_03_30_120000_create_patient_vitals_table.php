<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('bmi', 5, 2)->nullable();
            $table->unsignedSmallInteger('heart_rate')->nullable();
            $table->string('fbc_status')->nullable();
            $table->decimal('weight', 6, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('glucose_level')->nullable();
            $table->decimal('body_temperature', 4, 1)->nullable();
            $table->unsignedTinyInteger('spo2')->nullable();
            $table->timestamp('recorded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_vitals');
    }
};

