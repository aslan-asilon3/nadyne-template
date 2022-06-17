<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ap\Models\UnicharmMember;

class UnicharmMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        UnicharmMember::create([

            'name' => 'Hardik',
            'id_member' => 'Member1',
            'no_hp' => '081234567',
            'created_at' => now(),
            'updated_at' => now(),
            

        ]);

    }
}
