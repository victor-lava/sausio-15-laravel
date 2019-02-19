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
