<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('registry');
            $table->string('key');
            $table->string('name');
            $table->string('slug1');
            $table->string('slug2');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['registry', 'key'], 'unique_long');
            $table->unique(['slug1', 'slug2'], 'unique_slug');
        });

        Schema::create('article_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->references('id')->on('articles');
            $table->string('name');
            $table->string('type');
            $table->smallInteger('order');
            $table->timestamps();
        });

        Schema::create('article_fragments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->references('id')->on('articles');
            $table->string('type');
            $table->json('markup');
            $table->smallInteger('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_fragments');
        Schema::dropIfExists('article_sections');
        Schema::dropIfExists('articles');
    }
}
