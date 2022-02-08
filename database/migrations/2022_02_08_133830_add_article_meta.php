<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('author')->after('slug2');
            $table->enum('status', ['complete', 'incomplete', 'custom', 'stub'])->after('author');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->timestamp('edited_at')->nullable()->after('published_at');
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
            $table->dropColumn('author');
            $table->dropColumn('status');
            $table->dropColumn('published_at');
            $table->dropColumn('edited_at');
        });
    }
}
