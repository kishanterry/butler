<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class UserTableSeeder extends Seeder {

    public function run()
    {
        // TestDummy::times(10)->create('Butler\Models\User');
        DB::table('users')->truncate();

        $user = [
            'name' => 'Admin',
            'email' => 'admin@abit.bt',
            'password' => bcrypt('bhutan123'),
        ];

        DB::table('users')->insert($user);
    }

}