<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Role::insert([
           ['name' => 'Super Admin'],
           ['name' => 'Admin'],
           ['name' => 'User'],
           ['name' => 'Finance'],
       ]);

    }

}
