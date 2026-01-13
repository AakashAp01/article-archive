<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            // Link to your existing categories table
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            
            // Grid Position
            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            
            // Tags stored directly as a JSON array (e.g., ["design", "ui"])
            $table->json('tags')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};