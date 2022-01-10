<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $react = new Technology();
        $react->purpose_id = 1;
        $react->type_id = 1;
        $react->methodology_id = 1;
        $react->technology = 'React';
        $react->language = 'javaScript';
        $react->save();

        $vue = new Technology();
        $vue->purpose_id = 1;
        $vue->type_id = 1;
        $vue->methodology_id = 1;
        $vue->technology = 'Vue';
        $vue->language = 'JavaScript';
        $vue->save();
    
        $next = new Technology();
        $next->purpose_id = 1;
        $next->type_id = 1;
        $next->methodology_id = 2;
        $next->technology = 'Next';
        $next->language = 'JavaScript';
        $next->save();

        $nuxt = new Technology();
        $nuxt->purpose_id = 1;
        $nuxt->type_id = 1;
        $nuxt->methodology_id = 2;
        $nuxt->technology = 'Nuxt';
        $nuxt->language = 'JavaScript';
        $nuxt->save();

        $gatsby = new Technology();
        $gatsby->purpose_id = 1;
        $gatsby->type_id = 1;
        $gatsby->methodology_id = 3;
        $gatsby->technology = 'Gatsby';
        $gatsby->language = 'JavaScript';
        $gatsby->save();

        $nuxtSSG = new Technology();
        $nuxtSSG->purpose_id = 1;
        $nuxtSSG->type_id = 1;
        $nuxtSSG->methodology_id = 3;
        $nuxtSSG->technology = 'Nuxt';
        $nuxtSSG->language = 'JavaScript';
        $nuxtSSG->save();

        $laravelBlade = new Technology();
        $laravelBlade->purpose_id = 1;
        $laravelBlade->type_id = 2;
        $laravelBlade->methodology_id = 4;
        $laravelBlade->technology = 'Laravel + Blade';
        $laravelBlade->language = 'PHP';
        $laravelBlade->save();

        $laravelVue = new Technology();
        $laravelVue->purpose_id = 1;
        $laravelVue->type_id = 2;
        $laravelVue->methodology_id = 4;
        $laravelVue->technology = 'Laravel + Vue';
        $laravelVue->language = 'PHP + JavaScript';
        $laravelVue->save();

        $laravel = new Technology();
        $laravel->purpose_id = 1;
        $laravel->type_id = 2;
        $laravel->methodology_id = 5;
        $laravel->technology = 'Laravel';
        $laravel->language = 'PHP';
        $laravel->save();

        $spring = new Technology();
        $spring->purpose_id = 1;
        $spring->type_id = 2;
        $spring->methodology_id = 5;
        $spring->technology = 'Spring';
        $spring->language = 'Java';
        $spring->save();

        $ror = new Technology();
        $ror->purpose_id = 1;
        $ror->type_id = 2;
        $ror->methodology_id = 5;
        $ror->technology = 'Ruby on Rails';
        $ror->language = 'Ruby';
        $ror->save();

        $django = new Technology();
        $django->purpose_id = 1;
        $django->type_id = 2;
        $django->methodology_id = 5;
        $django->technology = 'Django';
        $django->language = 'Python';
        $django->save();

        $express = new Technology();
        $express->purpose_id = 1;
        $express->type_id = 2;
        $express->methodology_id = 5;
        $express->technology = 'Express';
        $express->language = 'JavaScript';
        $express->save();

        $ios = new Technology();
        $ios->purpose_id = 2;
        $ios->type_id = 3;
        $ios->methodology_id = 6;
        $ios->technology = 'iOS';
        $ios->language = 'Swift';
        $ios->save();

        $android = new Technology();
        $android->purpose_id = 2;
        $android->type_id = 3;
        $android->methodology_id = 6;
        $android->technology = 'Android';
        $android->language = 'Kotlin';
        $android->save();
    }
}
