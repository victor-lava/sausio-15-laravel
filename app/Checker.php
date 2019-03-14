<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checker extends Model
{
    public $timestamps = false;

    public function colorName() {
      return $this->color === 1 ? 'black' : 'white';
    }

    public function user() {
      return $this->belongsTo('App\User')->where('id', '!=', null);
    }

    public function createChecker(  int $game_id,
                                    int $y,
                                    int $x,
                                    int $color,
                                    $user_id) {
        $checker = new Checker();
        $checker->game_id = $game_id;
        $checker->user_id = $user_id;

        $yLyginis = ($y % 2 === 0) ? true : false;
        $xLyginis = ($x % 2 === 0) ? true : false;

        if(  ($yLyginis && !$xLyginis) || // jei y yra lyginis ir x yra nelyginis
             (!$yLyginis && $xLyginis)) { // jei y yra nelyginis ir x yra lyginis
            $checker->x = $x;
            $checker->y = $y;
            $checker->color = $color;
            $checker->save();
        } else { // jei y yra lyginis ir x yra lyginis, arba jei y yra nelyginis ir x yra nelyginis nespausdinu
            return false;
            // return continue;
        }
    }

}
