<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('categories', 'type')) {
                $table->string('type')->after('name');
            }
            if (!Schema::hasColumn('categories', 'color')) {
                $table->string('color')->after('type');
            }
            if (!Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->after('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'type', 'color', 'icon']);
        });
    }
};
