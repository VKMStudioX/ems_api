<?php

namespace Database\Seeders;

use App\Models\Methodology;
use Illuminate\Database\Seeder;

class MethodologiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spa = new Methodology();
        $spa->type_id = 1;
        $spa->name = 'SPA';
        $spa->save();

        $ssr = new Methodology();
        $ssr->type_id = 1;
        $ssr->name = 'SSR';
        $ssr->save();

        $ssg = new Methodology();
        $ssg->type_id = 1;
        $ssg->name = 'SSG';
        $ssg->save();

        $backfront = new Methodology();
        $backfront->type_id = 2;
        $backfront->name = 'Back-End + Front-End';
        $backfront->save();

        $restapi = new Methodology();
        $restapi->type_id = 2;
        $restapi->name = 'Rest Api';
        $restapi->save();

        $mobile = new Methodology();
        $mobile->type_id = 3;
        $mobile->name = 'Mobile';
        $mobile->save();

    }
}
