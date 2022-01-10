<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frontend = new Type();
        $frontend->purpose_id = 1;
        $frontend->name = 'Front-End';
        $frontend->save();

        $backend = new Type();
        $backend->purpose_id = 1;
        $backend->name = 'Back-End';
        $backend->save();   

        $mobile = new Type();
        $mobile->purpose_id = 2;
        $mobile->name = 'Mobile';
        $mobile->save();
    }
}
