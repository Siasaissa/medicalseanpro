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
        'marital_status',     // newly added
        'address',
        'phone_numbers',      // newly added
        'known_languages',    // newly added
        'dp',
        'title',              // newly added
        'hospital',           // newly added
        'year_of_experience', // newly added
        'location',           // newly added
        'job_description',    // newly added
        'start_date',         // newly added
        'end_date',           // newly added
        'about_membership',   // newly added
        'speciality',
        'service',
        'about_service',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // User model (for doctors)


}
