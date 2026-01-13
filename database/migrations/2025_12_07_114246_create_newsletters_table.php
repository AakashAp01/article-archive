<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique(); // Ensure unique emails
            $table->boolean('is_active')->default(true); // For unsubscribe logic later
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
