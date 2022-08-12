<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    public function scopeRunning()
    {
        return $this->where('start_time', '<=', now())->where('end_time', '>=', now());
    }

    public function scopeUpcoming()
    {
        return $this->where('start_time', '>=', Carbon::now());
    }

    public function scopeCompleted()
    {
        return $this->where('end_time', '<', Carbon::now());
    }


    public function scopeRunningForUser()
    {
        return $this->where('status', 1)
        ->whereHas('category', function($q) {
            $q->where('status', 1);
        })->whereHas('league', function($query) {
            $query->where('status', 1);
        })->where('start_time', '<=', now())->where('end_time', '>=', now());
    }
}
