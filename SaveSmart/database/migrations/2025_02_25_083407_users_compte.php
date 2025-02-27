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
        Schema::create('Compte_users', function(Blueprint $table){
            $table->integer('user_id');
            $table->integer('compte_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('compte_id')->references('id')->on('Comptes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Compte_users');
    }
};
