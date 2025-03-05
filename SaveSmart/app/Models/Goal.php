<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'current_amount',
        'deadline',
        'description',
        'icon',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentage()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        
        return min(100, round(($this->current_amount / $this->target_amount) * 100));
    }

    public function getRemainingAmount()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }
}

