<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The Neon pooler connection this app uses does not reliably persist
     * DDL run inside Laravel's automatic per-migration transaction wrapper
     * (observed: migrate reported success, but the constraint never
     * actually existed afterwards). Running outside a transaction avoids it.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cache', function (Blueprint $table) {
            $table->unique('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cache', function (Blueprint $table) {
            $table->dropUnique(['key']);
        });
    }
};
