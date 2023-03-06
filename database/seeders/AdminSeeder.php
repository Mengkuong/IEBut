<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Couchbase\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'admin', 'email'=>'admin@admin.com', 'email_verified_at'=> now(),    'password'=> bcrypt('adminpass')]);
    }
}
