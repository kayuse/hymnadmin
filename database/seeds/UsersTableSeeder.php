<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = str_random(10);
        $email = str_random(10).'@gmail.com';
        $apiToken = md5($name . $email);
        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('secret'),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
            'api_token' => $apiToken
        ]);
    }
}
