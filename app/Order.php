<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function getNicePrice() {
        return $this->price . ' $';
    }

}
