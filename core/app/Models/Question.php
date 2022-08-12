<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
}
