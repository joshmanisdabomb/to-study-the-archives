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
        Schema::create('build_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('build_id')->references('id')->on('builds');
            $table->string("path")->unique();
            $table->string("type")->nullable();
            $table->boolean("sources")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_files');
    }
};
