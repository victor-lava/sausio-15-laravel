<?php

use Illuminate\Database\Seeder;
// use Faker\Factory as Faker;
use App\Order;

class OrderSeeder extends Seeder
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

            $order = new Order();
            $order->user_id = $faker->numberBetween(1,10);
            $order->price = $faker->numberBetween(3,20);
            $order->description = $faker->realText($faker->numberBetween(100,500));
            $order->item_id = $faker->numberBetween(1,10);
            $order->save();

        }
        
    }
}
