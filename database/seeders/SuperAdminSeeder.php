<?php

namespace Database\Seeders;

use Couchbase\User;
use Illuminate\Database\Seeder;
use phpseclib3\Crypt\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
             \App\Models\User::create(['name'=>'Superadmin',
            'email'=>'super@gmail', 'email_verified_at'=> now(),
            'password'=> bcrypt('password')]);
    }
}
