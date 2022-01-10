<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->email = "emsAdmin@ems.com";
        $admin->first_name = "Admin";
        $admin->last_name = "Adminowski";
        $admin->password = "#6268ef874c339fe7a392fb06d008e9f52fa64e309069e97c71132276172a7c30439a14710613cee0e2c8179d720cdb9d7d7e14bdf19fd381f35052e2ceb54a99#"; // Qpq2n@xH#v
        $admin->is_admin = 1;
        $admin->save();

        $admin = new User();
        $admin->email = "emsUser@ems.com";
        $admin->first_name = "User";
        $admin->last_name = "Userowski";
        $admin->password ="#3d8cfadcae7e8073892165684d2b729b62ce7ec9ba005e3645c970dc4e528fd3399dfad61493fa0b618ba70edf969a682967c17f9790a4c0a62af046f56ce2a1#"; // 0#Kk2aE-8p
        $admin->is_admin = 0;
        $admin->save();

        $admin = new User();
        $admin->email = "emsResearch@ems.com";
        $admin->first_name = "Research";
        $admin->last_name = "Researchowski";
        $admin->password = "#3d8cfadcae7e8073892165684d2b729b62ce7ec9ba005e3645c970dc4e528fd3399dfad61493fa0b618ba70edf969a682967c17f9790a4c0a62af046f56ce2a1#"; // 0#Kk2aE-8p
        $admin->is_admin = 0;
        $admin->save();

    }
}
