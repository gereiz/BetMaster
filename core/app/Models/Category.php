<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
