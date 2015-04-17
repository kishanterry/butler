<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class AppTableSeeder extends Seeder {

    public function run()
    {
        TestDummy::times(3)->create('Butler\Models\App');
    }

}