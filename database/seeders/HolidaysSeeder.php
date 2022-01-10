<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holiday1 = new Holiday();
        $holiday1->start = "2022-01-06";
        $holiday1->save();
    }
}
