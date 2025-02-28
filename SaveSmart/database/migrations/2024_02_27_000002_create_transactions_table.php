<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['revenu', 'depense']);
            $table->decimal('montant', 10, 2);
            $table->string('description');
            $table->date('date');
            $table->foreignId('categorie_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained('comptes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
