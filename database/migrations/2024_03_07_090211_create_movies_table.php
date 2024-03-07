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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('tmbd_id');
            $table->string('media_type', 20);
            $table->string('title');
            $table->string('original_title');
            $table->string('original_language');
            $table->string('backdrop_path', 50);
            $table->string('poster_path', 50);
            $table->json('genre_ids');
            $table->date('release_date');
            $table->text('overview');
            $table->boolean('video');
            $table->boolean('adult');
            $table->decimal('popularity', 8, 3);
            $table->decimal('vote_average', 5, 3);
            $table->integer('vote_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
