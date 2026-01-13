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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_ip')->nullable()->after('remember_token');
            $table->timestamp('last_online')->nullable()->after('last_ip');
            $table->text('bio')->nullable()->after('last_online');
            $table->string('website')->nullable()->after('bio');
            $table->string('avatar')->nullable()->after('website');
            $table->string('google_id')->nullable()->unique()->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_ip', 'last_online', 'bio', 'website']);
        });
    }
};
