<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location=[
            ['id'=>1,'location_title'=>'Kamakwa','status'=>'1'],
            ['id'=>2,'location_title'=>'Kingongo Estate','status'=>'1'],
            ['id'=>3,'location_title'=>'Classic Estate','status'=>'1'],
            ['id'=>4,'location_title'=>'Meeting Point','status'=>'1'],
            ['id'=>5,'location_title'=>'Skuta','status'=>'1'],
            ['id'=>6,'location_title'=>'Ruringu Area','status'=>'1'],
            ['id'=>7,'location_title'=>'Around Dkut','status'=>'1'],
            ['id'=>8,'location_title'=>'Kangemi','status'=>'1']
        ];

        Location::insert($location);
    }
}
