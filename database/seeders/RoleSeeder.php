<?php

namespace Database\Seeders;

use App\Models\Role;
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
        Role::create(['role_name'=>'The Ceo']);
        Role::create(['role_name'=>'General Manager']);
        Role::create(['role_name'=>'Admin 1']);
        Role::create(['role_name'=>'Admin 2']);
        Role::create(['role_name'=>'Admin 3']);
        Role::create(['role_name'=>'Developer']);
    }
}
