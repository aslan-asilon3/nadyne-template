<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'aslan',
            'email' => 'aslanadmin@gmail.com',
            'password' => bcrypt('aslanadmin'),
        ]);
    }
}
