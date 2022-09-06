<?php

namespace Database\Seeders;

use App\Models\Tenantstatus;
use Illuminate\Database\Seeder;

class TenantstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenantstatus::create(['tenantstatus_title'=>'Approved']);
        Tenantstatus::create(['tenantstatus_title'=>'Rejected']);
    }
}
