<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'comptes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'family_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function ownedFamily()
    {
        return $this->hasOne(Family::class, 'owner_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function availableProfiles()
    {
        return $this->family ? Profile::where('family_id', $this->family_id)->get() : collect();
    }

    public function isOwnerOfFamily()
    {
        return $this->ownedFamily()->exists();
    }

    public function isMemberOfFamily()
    {
        return $this->family_id !== null;
    }
}
