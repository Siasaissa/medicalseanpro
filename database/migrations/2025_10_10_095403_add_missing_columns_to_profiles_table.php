<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('marital_status')->nullable()->after('blood_group');
            $table->string('phone_numbers')->nullable()->after('address');
            $table->string('known_languages')->nullable()->after('phone_numbers');
            $table->string('title')->nullable()->after('dp');
            $table->string('hospital')->nullable()->after('title');
            $table->string('year_of_experience')->nullable()->after('hospital');
            $table->string('location')->nullable()->after('year_of_experience');
            $table->text('job_description')->nullable()->after('location');
            $table->date('start_date')->nullable()->after('job_description');
            $table->date('end_date')->nullable()->after('start_date');
            $table->text('about_membership')->nullable()->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'phone_numbers',
                'known_languages',
                'title',
                'hospital',
                'year_of_experience',
                'location',
                'job_description',
                'start_date',
                'end_date',
                'about_membership',
            ]);
        });
    }
};
