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
        Schema::table('profiles', function (Blueprint $table) {
            // Add new fields for speciality & services
            $table->string('primary_speciality')->nullable()->after('about_membership');
            $table->text('secondary_specialities')->nullable()->after('primary_speciality');
            $table->text('services_offered')->nullable()->after('secondary_specialities');
            
            // Add new fields for availability
            $table->text('working_days')->nullable()->after('services_offered');
            $table->time('start_time')->nullable()->after('working_days');
            $table->time('end_time')->nullable()->after('start_time');
            $table->integer('session_duration')->nullable()->after('end_time'); // in minutes
            $table->string('break_time')->nullable()->after('session_duration');
            
            // Add new fields for consultation modes
            $table->string('video_platform')->nullable()->after('break_time');
            $table->string('voice_call_number')->nullable()->after('video_platform');
            $table->integer('home_visit_radius')->nullable()->after('voice_call_number'); // in km
            $table->string('chat_response_time')->nullable()->after('home_visit_radius');
            $table->string('emergency_contact')->nullable()->after('chat_response_time');
            
            // Add new fields for payment & fees
            $table->string('video_fee')->nullable()->after('emergency_contact');
            $table->string('voice_fee')->nullable()->after('video_fee');
            $table->string('chat_fee')->nullable()->after('voice_fee');
            $table->string('home_visit_fee')->nullable()->after('chat_fee');
            $table->text('payment_methods')->nullable()->after('home_visit_fee');
            $table->text('bank_account')->nullable()->after('payment_methods');
            
            // Add JSON fields for structured data
            $table->json('experiences')->nullable()->after('bank_account');
            $table->json('qualifications')->nullable()->after('experiences');
            $table->json('availability_schedule')->nullable()->after('qualifications');
            $table->json('consultation_modes')->nullable()->after('availability_schedule');
            $table->json('time_off')->nullable()->after('consultation_modes');
            $table->json('fees')->nullable()->after('time_off');
            
            // Add any other existing fields that might be missing
            if (!Schema::hasColumn('profiles', 'speciality')) {
                $table->string('speciality')->nullable();
            }
            
            if (!Schema::hasColumn('profiles', 'service')) {
                $table->string('service')->nullable();
            }
            
            if (!Schema::hasColumn('profiles', 'about_service')) {
                $table->text('about_service')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn([
                'primary_speciality',
                'secondary_specialities',
                'services_offered',
                'working_days',
                'start_time',
                'end_time',
                'session_duration',
                'break_time',
                'video_platform',
                'voice_call_number',
                'home_visit_radius',
                'chat_response_time',
                'emergency_contact',
                'video_fee',
                'voice_fee',
                'chat_fee',
                'home_visit_fee',
                'payment_methods',
                'bank_account',
                'experiences',
                'qualifications',
                'availability_schedule',
                'consultation_modes',
                'time_off',
                'fees',
            ]);
        });
    }
};