<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Compte extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'Comptes'; // Correction du nom de la table avec majuscule

    protected $fillable = ['email', 'password']; // Ajoute les colonnes que tu veux rendre modifiables

    protected $hidden = ['password']; // Cache le mot de passe

    public $timestamps = false; // Si ta table n'a pas de created_at / updated_at
}
