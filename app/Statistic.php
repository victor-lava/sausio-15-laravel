<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public function getPlayed() {
        // return $this->wins + $this->losses + $this->draws + $this->abandoned;
        return false;
    }
}
