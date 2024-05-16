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
        Schema::table('mod_versions', function (Blueprint $table) {
            $table->renameColumn('mod_version', 'name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mod_versions', function (Blueprint $table) {
            $table->renameColumn('name', 'mod_version');
        });
    }
};
