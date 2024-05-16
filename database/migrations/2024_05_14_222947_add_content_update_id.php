<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const TABLES = [
        'mods' => 'sources',
        'mod_versions' => 'changelog',
        'builds' => 'commit',
        'build_files' => 'sources',
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (self::TABLES as $schema => $after) {
            Schema::table($schema, function (Blueprint $table) use ($after) {
                $table->foreignId('content_id')->nullable()->after($after)->references('id')->on('content_updates');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = array_keys(self::TABLES);
        foreach ($tables as $schema) {
            Schema::table($schema, function (Blueprint $table) {
                $table->dropColumn('content_id');
            });
        }
    }
};
