<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public function getStatus() {
        $status = '';
        if($this->status === 0) {
            $status = 'Abandoned';
        } elseif($this->status === 1) {
            $status = 'Draw';
        }
        elseif($this->status === 2) {
            $status = 'Win';
        }
        elseif($this->status === 3) {
            $status = 'Lost';
        }
        return $status;
    }
    public function game() {
        return $this->hasOne('App\Game', 'id', 'game_id');
    }
}
