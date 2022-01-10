<?php

namespace Database\Seeders;

use App\Models\Absence;
use Illuminate\Database\Seeder;

class AbsencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emsUser = new Absence();
        $emsUser->user_id = 2;
        $emsUser->type = 'Absence';
        $emsUser->start = '2022-01-11';
        $emsUser->save();

        $research = new Absence();
        $research->user_id = 3;
        $research->type = 'Absence';
        $research->start = '2022-01-13';
        $research->save();
    }
}
