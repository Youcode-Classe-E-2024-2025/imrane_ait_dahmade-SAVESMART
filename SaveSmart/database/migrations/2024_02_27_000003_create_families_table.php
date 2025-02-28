<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('owner_id')->constrained('comptes')->onDelete('cascade');
            $table->timestamps();
        });

        // Ajouter la colonne family_id à la table users
        Schema::table('comptes', function (Blueprint $table) {
            $table->foreignId('family_id')->nullable()->constrained()->onDelete('set null');
        });

        // Créer la table profiles
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');

        Schema::table('comptes', function (Blueprint $table) {
            $table->dropForeign(['family_id']);
            $table->dropColumn('family_id');
        });

        Schema::dropIfExists('families');
    }
};
