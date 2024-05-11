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
        Schema::create('content_updates', function (Blueprint $table) {
            $table->id();
            $table->json("body");
            $table->json("meta")->nullable();
            $table->string("content")->nullable()->unique();
            $table->string("lang")->nullable()->unique();
            $table->string("images")->nullable()->unique();
            $table->string('mod_identifier');
            $table->string('mod_version');
            $table->string('mc_version');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_updates');
    }
};
