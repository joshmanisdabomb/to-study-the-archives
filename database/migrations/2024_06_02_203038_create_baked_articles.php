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
        Schema::create('baked_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->references('id')->on('articles')->cascadeOnDelete();
            $table->string('lang', 10);
            $table->text('name');
            $table->text('flavor');
            $table->text('html');
            $table->text('text');
            $table->json('all');
            $table->foreignId('content_id')->nullable()->references('id')->on('content_updates');
            $table->timestamps();
            $table->unique(['article_id', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baked_articles');
    }
};
