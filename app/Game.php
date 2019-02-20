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

    /**
     * Creates a vector movement array
     *
     * Vector movement array defines in which direction checker is moving.
     * Possible movements are:
     * x: +1, -1 (top-left),
     * x: -1, -1 (top-right),
     * x: +1, +1 (bottom-left),
     * x: -1, +1 (bottom-right)
     *
     * @return array
     */
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


    /**
     * Checks if the supplied coordinates are in the checker table range
     *
     * @param int $x horizontal axis coordinate for the checker/square
     * @param int $y vertical axis coordinate for the checker/square
     *
     * @return bool
     */
    private function isCoordinatesInRange(int $x, int $y): bool {
      $isCoordinates = false;

      if(($x >= 0 && $y >= 0) &&
         ($x <= 7 && $y <= 7)) {
            $isCoordinates = true;
      }

      return $isCoordinates;
    }

    /**
     * Gets checker moves
     *
     * Check around the checker and returns it's possible movements
     *
     * @param Checker $checker Instance of Checker
     *
     * @return array
     */
    public function getMoves(Checker $checker): array {
      $moves = [];
      $vectors = $this->createVectors();

      foreach ($vectors as $vector) {
        $x = $checker->x + $vector['x'];
        $y = $checker->y + $vector['y'];

        if($this->isCoordinatesInRange($x, $y)) {

          $isEmpty = false;
          $isEnemy = false;
          $isFight = false;

          $foundChecker = $this->findCheckerByCoordinates($x, $y);

          if(!$foundChecker) { $isEmpty = true; } // if we find checker, then it's nt
          elseif($foundChecker->color !== $checker->color) { $isEnemy = $foundChecker; }


          if($isEnemy instanceof Checker) {
            $enemyX = $isEnemy->x + $vector['x'];
            $enemyY = $isEnemy->y + $vector['y'];


            // dd($enemyX);
            if($this->isCoordinatesInRange($enemyX, $enemyY)) {
              $isEmptySpace = $this->findCheckerByCoordinates($enemyX, $enemyY);
              if($isEmptySpace === false) { $isFight = true; }
            }

          }

          $moves[] = ['x' => $x,
                      'y' => $y,
                      'vectors' => ['x' => $vector['x'],
                                    'y' => $vector['y']],
                      'empty' => $isEmpty,
                      'enemy' => $isEnemy,
                      'fight' => $isFight];
         }
      }

      $moves = $this->filterPossibleMoves(  $moves,
                                            $checker);
      return $moves;
    }

    /**
     * Filters the possible movements
     *
     * Removes the movements that are not possible, for ex. if we must to cut the checker, then we don't need to return the squares that are empty
     *
     * @param array $moves Instance of Checker
     * @param Checker $checker Instance of Checker
     *
     * @return array
     */
    public function filterPossibleMoves($moves,
                                        $checker) {
      $emptyMoves = [];
      $fightMoves = [];

      foreach ($moves as $move) {
        $coordinates = ['x' => $move['x'],
                        'y' => $move['y']];

        if( $move['fight'] === true) { // fight is happening, add to fightMoves array
          $coordinates['x'] += $move['vectors']['x'];
          $coordinates['y'] += $move['vectors']['y'];

          $fightMoves[] = $coordinates;
        } elseif ($move['empty'] === true) { // if empty true

          // if moving forward or moving backwards
          if(($move['vectors']['y'] > 0 && $checker->color === 1) || ($move['vectors']['y'] < 0 && $checker->color === 0)) {
                $emptyMoves[] = $coordinates;
          }
        }
      }

      // if there are any fight moves, then return them (need to fight!) don't return empty
      return count($fightMoves) === 0 ? $emptyMoves : $fightMoves;
    }

    /**
     * Finds checker by coordinates
     *
     * Finds checker by coordinates from the checker model
     *
     * @param int $x checker horizontal axis
     * @param int $y checker vertical axis
     *
     * @return Checker
     */
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
