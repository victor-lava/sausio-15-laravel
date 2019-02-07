<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function firstPlayer() {
        return $this->hasOne('App\User', 'id', 'first_user_id');
    }

    public function secondPlayer() {
        return $this->hasOne('App\User', 'id', 'second_user_id');
    }
}
