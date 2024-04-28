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
        Schema::create('mods', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('name');
            $table->string('short');
            $table->boolean('legacy')->default(false);
            $table->string('repository');
            $table->string('repository_branch')->default('main');
            $table->boolean('tags')->default(true);
            $table->boolean('sources')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mods');
    }
};
