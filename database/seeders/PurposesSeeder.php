<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Seeder;

class PurposesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $web = new Purpose();
        $web->name = 'Web';
        $web->save();

        $mobile = new Purpose();
        $mobile->name = 'Mobile';
        $mobile->save();
    }
}
