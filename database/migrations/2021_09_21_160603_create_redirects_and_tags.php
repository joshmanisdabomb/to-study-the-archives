<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsAndTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_redirects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->references('id')->on('articles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('registry');
            $table->string('key');
            $table->string('name')->nullable();
            $table->string('slug1');
            $table->string('slug2');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['registry', 'key'], 'unique_long');
            $table->unique(['slug1', 'slug2'], 'unique_slug');
        });

        Schema::create('article_tags', function (Blueprint $table) {
            $table->foreignId('article_id')->references('id')->on('articles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('tag');
            $table->primary(['article_id', 'tag']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_tags');
        Schema::dropIfExists('article_redirects');
    }
}
