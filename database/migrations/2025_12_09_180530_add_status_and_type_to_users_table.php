<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add status (0 = inactive, 1 = active)
            $table->tinyInteger('status')
                  ->default(1)
                  ->after('password');

            // Add type (admin, user, editor, etc.)
            $table->string('type', 50)
                  ->default('user')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'type']);
        });
    }
};
