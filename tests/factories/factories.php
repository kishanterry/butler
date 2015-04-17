<?php

$factory('Butler\Models\User', [
    'name' => $faker->name,
    'email' => $faker->email,
    'password' => bcrypt('bhutan123'),
]);

$factory('Butler\Models\App', [
    'app_id' => 'abc123',
    'name' => $faker->firstName,
    'app_key' => $faker->sha1('app_key'),
    'app_secret' => $faker->sha1('app_secret'),
    'user_id' => 1,
    'enabled' => true
]);
