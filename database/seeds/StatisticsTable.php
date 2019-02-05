<?php

use Illuminate\Database\Seeder;
use App\Statistic;

class StatisticsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(0,50) as $number) {

            $statistic = new Statistic();
            $statistic->user_id = $faker->numberBetween(1,100);
            $statistic->wins = $faker->numberBetween(1,100);
            $statistic->losses = $faker->numberBetween(1,100);
            $statistic->draws = $faker->numberBetween(1,100);
            $statistic->abandoned = $faker->numberBetween(1,100);
            $statistic->save();
        }
        
    }
}
