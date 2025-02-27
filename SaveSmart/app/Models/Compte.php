<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;
    protected $table = 'Comptes'; 

    
protected $fillable = [  
        'email',
        'password',
    ];
        public $timestamps = false; // Désactive les timestamps
    
    
}
