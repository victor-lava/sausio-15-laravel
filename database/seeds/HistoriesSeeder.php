<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Game;
use App\History;

class HistoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $userCount = User::count();
        $gameCount = Game::count();

        foreach (range(0,1) as $number) {
            $history = new History();
            $history->game_id = $faker->numberBetween(1, $gameCount);
            $history->user_id = $faker->numberBetween(1, $userCount);
            $history->status = $faker->numberBetween(0, 3);
            $history->save();
        }
    }
}
