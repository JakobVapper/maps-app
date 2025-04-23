<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('image');
                $table->text('description');
                $table->string('genre');
                $table->integer('release_year');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};