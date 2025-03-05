<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // Ajoute une clé primaire auto-incrémentée 'id'
            $table->string('name'); // Ajoute une colonne 'name' de type string
            $table->string('email')->unique(); // Ajoute une colonne 'email' unique
            $table->timestamps(); // Ajoute les colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Revenir sur la migration (rollback).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users'); // Supprime la table 'users'
    }
}
