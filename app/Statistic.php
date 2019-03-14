<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'wins', 'losses', 'draws', 'abandoned'
    ];

    public function getPlayed() {
        return $this->wins + $this->losses + $this->draws + $this->abandoned;
        // return false;
    }
}
