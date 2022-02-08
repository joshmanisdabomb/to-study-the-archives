<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticleHeadings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('name')->change();
        });
        Schema::table('article_sections', function (Blueprint $table) {
            $table->text('name')->change();
        });
        Schema::table('article_redirects', function (Blueprint $table) {
            $table->text('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('name')->change();
        });
        Schema::table('article_sections', function (Blueprint $table) {
            $table->string('name')->change();
        });
        Schema::table('article_redirects', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }
}