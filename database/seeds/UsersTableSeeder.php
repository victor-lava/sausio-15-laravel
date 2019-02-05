<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker\Factory::create();

        // foreach (range(0,50) as $number) {
        //     $user = new User();
        //     $user->name = $faker->realText($faker->numberBetween(100,500));
        //     $user->email = $faker->realText($faker->numberBetween(100,500))."@admin.com";
        //     $user->password = $faker->realText(bcrypt('admin'));
        //     $user->location = "smth";
        //     $user->online = "true";
        //     $user->save();
        // }
        $user = new User();
            $user->name = "admin";
            $user->email = "admin@admin.com";
            $user->password = bcrypt('admin');
            $user->location = "smth";
            $user->online = "true";
            $user->save();
        
    }
}
