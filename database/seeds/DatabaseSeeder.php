<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTable::class);
        $this->call(StatisticsTable::class);
        $this->call(GamesSeeder::class);
        $this->call(HistoriesSeeder::class);
        $this->call(CheckerSeeder::class);
    }
}
