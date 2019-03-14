<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Game;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $count = User::count();

        foreach (range(0,0) as $number) {

            $first_id = $faker->numberBetween(1, $count);
            $second_id = $faker->numberBetween(1, $count);

            while($first_id === $second_id) {
                $second_id = $faker->numberBetween(1, $count);
            }

            $game = new Game();
            $game->first_user_id = 1;
            $game->second_user_id = 2;
            $game->hash = md5($game->first_user_id . time());
            $game->started_at = $faker->time('Y-m-d H:i:s');
            $game->status = 0;
            $game->save();
        }
    }
}
