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

    public function isOngoing() {
        return $this->status === 1 ? true : false;
    }

    public function getStatus() {
        $status = '';
        switch ($this->status) {
            case 0:
                $status = 'Waiting';
                break;

            case 1:
                $status = 'Ongoing';
                break;

            case 2:
                $status = 'Completed';
                break;

        }
        return $status;
    }
}
