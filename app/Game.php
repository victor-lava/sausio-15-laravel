<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $className;
    public $name;

    public function getDuration() {

        $gameStarted = new \DateTime($this->started_at);
        $now = new \DateTime();

        $diff = $gameStarted->diff($now);
        $minutes = ($diff->h * 60) + $diff->i;

        return $minutes . ' min. ' . $diff->s. ' s.';

    }

    public function firstPlayer() {
        return $this->hasOne('App\User', 'id', 'first_user_id');
    }

    public function secondPlayer() {
        return $this->hasOne('App\User', 'id', 'second_user_id');
    }

    public function badgeStatus() {

        $this->className = $this->status === 0 ? 'warning' : 'success';
        $this->name = $this->status === 0 ? 'Waiting' : 'Ongoing';

        return $this;
    }

    public function buttonStatus() {

        $this->className = $this->status === 0 ? 'success' : 'primary';
        $this->name = $this->status === 0 ? 'Play' : 'Watch';

        return $this;
    }

}
