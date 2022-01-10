<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventsDefaultsForBg;

class EventsDefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $absenceDef = new EventsDefaultsForBg();
        $absenceDef->type = "Absence";
        $absenceDef->title = "";
        $absenceDef->backgroundColor = "#ff7777";
        $absenceDef->display = "background";
        $absenceDef->className = "absence";
        $absenceDef->save();

        $reminderDef = new EventsDefaultsForBg();
        $reminderDef->type = "Reminder";
        $reminderDef->title = "";
        $reminderDef->backgroundColor = "#fff000";
        $reminderDef->display = "background";
        $reminderDef->className = "reminder";
        $reminderDef->save();

    }
}
