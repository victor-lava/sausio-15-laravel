<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checker extends Model
{
    public $timestamps = false;

    public function colorName() {
      return $this->color === 1 ? 'black' : 'white';
    }
}
