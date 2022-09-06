<?php

namespace Database\Seeders;

use App\Models\Rental_category;
use Illuminate\Database\Seeder;

class RentalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rentalcategory=[
            ['id'=>1,'rentalcat_title'=>'Residential','rentalcat_url'=>'residential','status'=>'1'],
            ['id'=>2,'rentalcat_title'=>'Commercial','rentalcat_url'=>'commercial','status'=>'1']
        ];

        Rental_category::insert($rentalcategory);
    }
}
