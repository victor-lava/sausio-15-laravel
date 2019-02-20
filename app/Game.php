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

    public function checkers() {
        return $this->hasMany('App\Checker');
    }

    private function createVectors() {
      $y = 1;
      $x = 1;
      $vectors = [];

      for ($i = 0; $i < 4; $i++) {

        if($i % 2) { $y *= -1; $x *= -1; }
        else { $y *= -1; $x *= 1; }

        $vectors[] = ['x' => $x, 'y' => $y];
      }

      return $vectors;
    }

    public function getMoves($checker) {
      $moves = [];

      if($checker->color === 1) { // black

        foreach ($this->createVectors() as $vector) {
          $moves[] = $this->isMovePossible( $checker->x - $vector['x'],
                                            $checker->y - $vector['y'],
                                            $checker->color);
        }
        
        dd($moves);


        // foreach ($moves as $key => $value) {
        //   if($value['enemy'] instanceof Checker) {
        //     $isMovePossible = $this->isMovePossible(
        //                                       $moves[$key]['enemy']->x + 1,
        //                                       $moves[$key]['enemy']->y + 1,
        //                                       $moves[$key]['enemy']->color);
        //     if($isMovePossible['empty']) {
        //       $moves[$key]['fight'] = true;
        //     }
        //   }
        // }


      } else  { // white
        $moves[] = $this->isMovePossible($checker->x - 1, $checker->y - 1);
        $moves[] = $this->isMovePossible($checker->x + 1, $checker->y - 1);
      }

      return $moves;
    }

    public function isMovePossible($x, $y, $color) {
      $checker = $this->findCheckerByCoordinates($x, $y);
      $coordinates = ['x' => $x,
                      'y' => $y,
                      'empty' => false,
                      'enemy' => false,
                      'fight' => false];

      if($checker == false) { // no checker found
        $coordinates['empty'] = true;
      }
      elseif($checker->color !== $color) { // enemy found, because different colors
        $coordinates['enemy'] = $checker;
      }

      return $coordinates;
    }

    public function findCheckerByCoordinates($x, $y) {
        $result = false;

        foreach ($this->checkers as $checker) {
            if( $checker->x === $x &&
                $checker->y === $y) {
                    $result = $checker;
                    break;
            }
        }

        return $result;
    }

    public function createGameTable() {
        $table = [];
        $alphabet = 'abcdefgh';

        $idNumber = 8;
        for ($y = 0; $y <= 7; $y++) {
            $table[$y] = [];

            for ($x = 0; $x <= 7; $x++) {
                $yLyginis = ($y % 2 === 0) ? true : false;
                $xLyginis = ($x % 2 === 0) ? true : false;
                $checker = false;
                $idLetter = $alphabet[$x];

                $table[$y][$x]['id'] = $idLetter . $idNumber;

                if(  ($yLyginis && !$xLyginis) || // jei y yra lyginis ir x yra nelyginis
                     (!$yLyginis && $xLyginis)) { // jei y yra nelyginis ir x yra lyginis
                    $color = 'black';
                    // echo $x;
                    $isChecker = $this->findCheckerByCoordinates($x, $y);

                    if($isChecker) {
                        $checker = $isChecker;
                    }

                } else { // jei y yra lyginis ir x yra lyginis, arba jei y yra nelyginis ir x yra nelyginis nespausdinu
                    $color = 'white';
                }
                $table[$y][$x]['color'] = $color;
                $table[$y][$x]['checker'] = $checker;
            }
            $idNumber--;
        }

        return $table;
    }
}
