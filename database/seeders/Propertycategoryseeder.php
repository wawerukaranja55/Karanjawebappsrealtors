<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Propertycategory;

class Propertycategoryseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertycategory=[
            ['id'=>1,'propertycat_title'=>'Land','propertycat_url'=>'land','status'=>'1'],
            ['id'=>2,'propertycat_title'=>'Building','propertycat_url'=>'building','status'=>'1'],
            ['id'=>3,'propertycat_title'=>'Vehicles','propertycat_url'=>'vehicles','status'=>'1'],
            ['id'=>4,'propertycat_title'=>'Auction_Items','propertycat_url'=>'auction_items','status'=>'1']
        ];

        Propertycategory::insert($propertycategory);
    }
}
