<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $with = ['players'];

    /**
     * People that played this game.
     *
     * @return BelongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_winner', 'score')
            ->orderByDesc('pivot_score')
            ->orderByDesc('pivot_is_winner')
            ->withTimestamps();
    }

    public function getWinnerAttribute()
    {
        return $this->players->first();
    }

    public function getLoserAttribute()
    {
        return $this->players->last();
    }

    public function getTitleAttribute()
    {
        return $this->players->first()->name.' vs '.$this->players->last()->name;
    }

    public function getScoresAttribute()
    {
        return $this->players->first()->pivot->score.' / '.$this->players->last()->pivot->score;
    }

    public function hasScores()
    {
        return $this->players->first()->pivot->score || $this->players->last()->pivot->score;
    }
}
