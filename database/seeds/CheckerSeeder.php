<?php

use Illuminate\Database\Seeder;
use App\Game;
use App\Checker;

class CheckerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Game::count();

        for ($b = 1; $b <= $count; $b++) {

            for ($y = 0; $y <= 2; $y++) { // black
                for ($x = 0; $x <= 7; $x++) {
                    $this->createChecker($b, $y, $x, 1, 1);
                }
            }

            for ($y = 7; $y >= 5; $y--) { // white
                for ($x = 7; $x >= 0; $x--) {
                    $this->createChecker($b, $y, $x, 0, 2);
                }
            }

        }

    }

    private function createChecker( int $game_id,
                                    int $y,
                                    int $x,
                                    int $color,
                                    int $user_id) {
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
