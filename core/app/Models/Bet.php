<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    public function scopePending()
    {
        return $this->where('status', 0);
    }

    public function scopeWon()
    {
        return $this->where('status', 1);
    }

    public function scopeLose()
    {
        return $this->where('status', 2);
    }

    public function scopeRefunded()
    {
        return $this->where('status', 3);
    }

    public function getStatusBadgeAttribute()
    {
        $class = 'badge badge--';

        if($this->status == 0){
            $class .= 'warning';
            $text =  'Pending';
        }elseif ($this->status == 1){
            $class .= 'success';
            $text =  'Won';
        }elseif ($this->status == 2){
            $class .= 'danger';
            $text =  'Lose';
        }else{
            $class .= 'dark';
            $text =  'Refunded';
        }
        return "<span class=\"$class\">".trans($text)."</span>";
    }

}
