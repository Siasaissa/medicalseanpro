<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'sex',
        'dob',
        'blood_group',
        'marital_status',
        'address',
        'phone_numbers',
        'known_languages',
        'dp',
        'title',
        'hospital',
        'year_of_experience',
        'location',
        'job_description',
        'start_date',
        'end_date',
        'about_membership',
        'speciality',
        'service',
        'about_service',
        // New fields for the added sections
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
        'experiences', // JSON field for multiple experiences
        'qualifications', // JSON field for qualifications
        'availability_schedule', // JSON field for weekly schedule
        'consultation_modes', // JSON field for enabled consultation modes
        'time_off', // JSON field for time off periods
        'fees', // JSON field for consultation fees
    ];

    protected $casts = [
        'experiences' => 'array',
        'qualifications' => 'array',
        'availability_schedule' => 'array',
        'consultation_modes' => 'array',
        'time_off' => 'array',
        'fees' => 'array',
        'services_offered' => 'array',
        'working_days' => 'array',
        'payment_methods' => 'array',
        'secondary_specialities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}