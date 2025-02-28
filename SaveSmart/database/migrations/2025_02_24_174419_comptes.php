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
        // Cette migration n'est plus nécessaire car la table est créée dans 2014_10_12_000000_create_users_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration n'est plus nécessaire
    }
};
