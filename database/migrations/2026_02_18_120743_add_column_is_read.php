// database/migrations/xxxx_xx_xx_xxxxxx_add_is_read_to_chats_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // If you don't have is_read column yet
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('message');
            $table->timestamp('read_at')->nullable()->after('is_read');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['is_read', 'read_at']);
        });
    }
};