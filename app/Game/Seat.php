<?php

namespace App\Game;

class Seat
{

  public $game;
  public $userID;

  public function __construct($game) {
    $this->game = $game;
    $this->userID = null;
  }

  public function setUser($userID) {
    $this->userID = $userID;
  }

  public function seatToWhite() {
      $this->game->update(['first_user_id' => $this->userID]);
  }

  public function seatToBlack() {
      $this->game->update(['second_user_id' => $this->userID]);
  }

  public function doISeatIn(string $seatColor) {
      $doSeat = false;
      if($seatColor === 'white' &&
        $this->game->first_user_id === $this->userID
        ) {
        $doSeat = true;
      } elseif ($seatColor === 'black' &&
                $this->game->second_user_id === $this->userID) {
        $doSeat = true;
      }
      return $doSeat;
  }

  public function to( string $seatColor,
                      int $userID) {

    $this->setUser($userID);

    if( $seatColor === 'white') {

        if($this->isEmptySeat('white')) {
          $this->seatToWhite();
          if($this->doISeatIn('black')) { $this->unseat('black'); }
        }

    } elseif ($seatColor === 'black') {
      if($this->isEmptySeat($seatColor)) {
        $this->seatToBlack();
        if($this->doISeatIn('white')) { $this->unseat('white'); }
      }
    }
  }

  public function isEmptySeat(string $seatColor): bool {
    $isEmpty = false;

    if( $this->game->first_user_id === null ||
        $this->game->second_user_id === null) {
      $isEmpty = true;
    }

    return $isEmpty;
  }

  public function unseat(string $seatColor) {
    if($seatColor === 'white') { $this->game->update(['first_user_id' => null]); }
    elseif($seatColor === 'black') { $this->game->update(['second_user_id' => null]); }
  }

}
