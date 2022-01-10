<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(EventsDefSeeder::class);
        $this->call(HolidaysSeeder::class);
        $this->call(AbsencesSeeder::class);
        $this->call(PurposesSeeder::class);
        $this->call(TypesSeeder::class);
        $this->call(MethodologiesSeeder::class);
        $this->call(TechnologiesSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
