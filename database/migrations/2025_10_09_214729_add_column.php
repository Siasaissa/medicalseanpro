<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('speciality')->nullable()->after('dp');
            $table->string('service')->nullable()->after('speciality');
            $table->text('about_service')->nullable()->after('service');
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['speciality', 'service', 'about_service']);
        });
    }
};
