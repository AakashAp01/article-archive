<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); 
            $table->string('key');         
            $table->longText('value')->nullable();
            $table->boolean('is_locked')->default(false); 
            $table->timestamps();

            // Prevent duplicate keys within the same group
            $table->unique(['group', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};