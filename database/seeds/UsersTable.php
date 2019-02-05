<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt('admin');
        $user->location = $faker->country() . ', ' . $faker->city();
        $user->online = 1;
        $user->gravatar_url = $this->createGravatarUrl($user->email);
        $user->admin = 1;
        $user->save();


        foreach (range(0,50) as $number) {

            $user = new User();
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->password = bcrypt('simple');
            $user->location = $faker->country() . ', ' . $faker->city();
            $user->gravatar_url = $this->createGravatarUrl($user->email);
            $user->online = $faker->numberBetween(0,1);
            $user->save();

        }
    }

    public function createGravatarUrl(string $email): string {
        return 'https://www.gravatar.com/avatar/'.md5($email).'?s=200&d=mp';
    }
}
