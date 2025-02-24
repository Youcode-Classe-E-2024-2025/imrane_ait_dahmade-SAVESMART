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
        Schema::create('transaction',function(Blueprint $table){
            $table->id();
            $table->string('montant');
            $table->string('type');
            $table->timestamp('Date_transaction')->default(now());
            $table->primary('id');
            $table->string('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
