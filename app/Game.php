<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $className;
    public $name;

    public function getDuration() {
        $durationArray = explode(':', $this->duration);
        $minutes  = $durationArray[1];

        if($durationArray[0] != '00') {
            $minutes = ($durationArray[0] * 60) + $durationArray[1];
        }
        
        return $minutes . ' min. ' . $durationArray[2] . ' s.';
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
