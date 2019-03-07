<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'first_user_id', 'second_user_id', 'started_at', 'status'
    ];

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
        return $this->hasMany('App\Checker')->where('dead', 0);
    }

    public function createVectors() {

      $vectors = [];
      $x = 1;
      $y = 1;

      for ($i = 0; $i < 4; $i++) {
        if($i % 2) {
          $x *= -1;
          $y *= 1;
        } else {
          $x *= 1;
          $y *= -1;
        }

        $vectors[] = ['x' => $x, 'y' => $y];
      }

      return $vectors;
    }

    public function isCoordinatesInRange($x, $y) {
      $boolean = false;
      if(($x >= 0 && $y >= 0) && ($x <= 7 && $y <= 7)) { $boolean = true; }
      return $boolean;
    }

    public function getAround(Checker $checker) {

      $moves = [];
      $vectors = $this->createVectors();
      foreach ($vectors as $vector) {
        $x = $checker->x + $vector['x'];
        $y = $checker->y + $vector['y'];

        if($this->isCoordinatesInRange($x, $y)) {

          $foundChecker = $this->findCheckerByCoordinates($x, $y);
          $isEnemy = false;
          $isEmpty = false;
          $isFight = false;

          if(!$foundChecker) { $isEmpty = true; }
          elseif($checker->color !== $foundChecker->color) {
            $isEnemy = $foundChecker;
            $enemyX = $isEnemy->x + $vector['x'];
            $enemyY = $isEnemy->y + $vector['y'];

            if($this->isCoordinatesInRange($enemyX, $enemyY) &&
              !$this->findCheckerByCoordinates($enemyX, $enemyY)) {
                $isFight = true;
                $x = $enemyX;
                $y = $enemyY;
              }
          }



          $moves[] = ['x' => $x,
                      'y' => $y,
                      'vector' => $vector,
                      'empty' => $isEmpty,
                      'enemy' => $isEnemy,
                      'fight' => $isFight];

        }
      }

     return $moves;
    }

    public function filterMoves(Checker $checker,
                                array $moves) {
      $fightMoves = [];
      $emptyMoves = [];

      foreach ($moves as $move) {

        if($move['fight'] === true) {
          $fightMoves[] = $move;
        } elseif($move['empty'] === true) {

          if(($checker->color === 0 && $move['vector']['y'] < 0) ||
              $checker->color === 1 && $move['vector']['y'] > 0) {
                $emptyMoves[] = $move;
          }

        }

      }

      return count($fightMoves) > 0 ? $fightMoves : $emptyMoves;
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

    public function calcEnemyCoordinatesBetween(array $startingCoordinates,
                                                array $movementVector) {
      $enemy = [];

      $enemy['x'] = $startingCoordinates['x'] + $movementVector['x'];
      $enemy['y'] = $startingCoordinates['y'] + $movementVector['y'];

      return $enemy;
    }

    public function calcVector(array $from, array $to, $steps = 1) {

      $vector = [];

      $vector['x'] = ($from['x'] - $to['x']) / -$steps;
      $vector['y'] = ($from['y'] - $to['y']) / -$steps;

      return $vector;
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

    public function getAround(Checker $checker): array {
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
          elseif($foundChecker->color !== $checker->color) {
            $isEnemy = $foundChecker;
            $enemyX = $isEnemy->x + $vector['x'];
            $enemyY = $isEnemy->y + $vector['y'];

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
      // dd($moves);
      return $moves;
    }

    /**
     * Gets checker possible moves
     *
     *
     * @param Checker $checker Instance of Checker
     *
     * @return array
     */
    public function getMoves(Checker $checker): array {
      $around = $this->getAround($checker);

      $moves = $this->filterPossibleMoves(  $around,
                                            $checker);
// dd($moves);
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
                        'y' => $move['y'],
                        'enemy' => $move['enemy'],
                        'fight' => false];

        if( $move['fight'] === true) { // fight is happening, add to fightMoves array
          $coordinates['x'] += $move['vectors']['x'];
          $coordinates['y'] += $move['vectors']['y'];
          $coordinates['fight'] = true;

          $fightMoves[] = $coordinates;
        } elseif ($move['empty'] === true) { // if empty true

          // if moving forward or moving backwards
          if( ($move['vectors']['y'] > 0 && $checker->color === 1) ||
              ($move['vectors']['y'] < 0 && $checker->color === 0)) {
                $emptyMoves[] = $coordinates;
          }

        }
      }

      // dd($fightMoves);
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

    public function isClickable() {

    }

    public function createGameTable($authHash, $colorNumber) {
        $table = [];
        $alphabet = 'abcdefgh';

        $idNumber = 8;
        for ($y = 0; $y <= 7; $y++) {
            $table[$y] = [];

            for ($x = 0; $x <= 7; $x++) {
                $yLyginis = ($y % 2 === 0) ? true : false;
                $xLyginis = ($x % 2 === 0) ? true : false;
                $checker = false;
                $isClickable = false;
                $idLetter = $alphabet[$x];

                $table[$y][$x]['id'] = $idLetter . $idNumber;

                if(  ($yLyginis && !$xLyginis) || // jei y yra lyginis ir x yra nelyginis
                     (!$yLyginis && $xLyginis)) { // jei y yra nelyginis ir x yra lyginis
                    $color = 'black';

                    $isChecker = $this->findCheckerByCoordinates($x, $y);

                    if($isChecker) {
                        $checker = $isChecker;
                        // dd($color);
                        if( $checker->user->token === $authHash &&
                            $checker->color === $colorNumber) {
                              $isClickable = true;
                            }
                    } else { $isClickable = true; }

                } else { // jei y yra lyginis ir x yra lyginis, arba jei y yra nelyginis ir x yra nelyginis nespausdinu
                    $color = 'white';
                }

                $table[$y][$x]['color'] = $color;
                $table[$y][$x]['checker'] = $checker;
                $table[$y][$x]['clickable'] = $isClickable;

            }
            $idNumber--;
        }
        // dd($table);
        return $table;
    }
}
