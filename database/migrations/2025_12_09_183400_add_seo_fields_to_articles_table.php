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
        Schema::table('articles', function (Blueprint $table) {
            // Thumbnail
            $table->string('thumbnail')->nullable()->after('content');

            // SEO Fields
            $table->string('meta_title')->nullable()->after('slug');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'thumbnail',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
