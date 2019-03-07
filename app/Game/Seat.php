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

  /**
   * Set's the userID for later usage
   *
   * @param int $userID
   */
  public function setUser(int $userID) {
    $this->userID = $userID;
  }

  /**
   * Seat's user to the white position
   */
  public function seatToWhite() {
      $this->game->update(['first_user_id' => $this->userID]);
  }

  /**
   * Seat's user to the black position
   */
  public function seatToBlack() {
      $this->game->update(['second_user_id' => $this->userID]);
  }

  /**
   * Tell's if the current user seats in the requested position
   *
   * @param string $seatColor white or black
   *
   * @return bool
   */
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

  /**
   * Seat's user in the desired position
   *
   * Seat's user in the desired position and unseat's it if it already seated in the opposite position. Also, returns false if user can't be seated there.
   *
   * @param string $seatColor white or black
   * @param int $userID
   *
   * @return bool
   */
  public function to( int $userID,
                      string $seatColor) {

    $seated = false;
    $this->setUser($userID);

    if( $seatColor === 'white') {

        if($this->isEmptySeat($seatColor)) {
          $this->seatToWhite();
          $seated = true;
          if($this->doISeatIn('black')) { $this->unseat('black'); }
        }

    } elseif ($seatColor === 'black') {

      if($this->isEmptySeat($seatColor)) {
        $this->seatToBlack();
        $seated = true;
        if($this->doISeatIn('white')) { $this->unseat('white'); }
      }

    }

    return $seated;
  }

  public function isBothSeated() {
    $isBoth = false;

    if(!$this->isEmptySeat('black') &&
       !$this->isEmptySeat('white')) {
         $isBoth = true;
    }

    return $isBoth;
  }
  /**
   * Check's if seat is empty
   *
   * @param string $seatColor white or black
   *
   * @return bool
   */
  public function isEmptySeat(string $seatColor): bool {
    $isEmpty = false;

    if( $this->game->first_user_id === null ||
        $this->game->second_user_id === null) {
      $isEmpty = true;
    }

    return $isEmpty;
  }

  /**
   * Unseat's user from the selected seat
   *
   * @param string $seatColor white or black
   *
   */
  public function unseat(string $seatColor) {
    if($seatColor === 'white') { $this->game->update(['first_user_id' => null]); }
    elseif($seatColor === 'black') { $this->game->update(['second_user_id' => null]); }
  }

}
