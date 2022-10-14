<?php

namespace Database\Seeders;

use App\Models\Rental_house;
use Illuminate\Database\Seeder;

class RentalhouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Rental_house::create([
            'rental_name'=>'AdminRentalHouse',
            'rental_slug'=>'admin_rental_house',
            'monthly_rent'=>'1',
            'rental_address'=>'karanja street,Skuta',
            'rental_details'=>'am the house description for the admin',
            'rental_image'=>'AdminRentalHouse.png',
            'rentalcat_id'=>'2',
            'rental_status'=>'1',
            'location_id'=>'1',
            'landlord_id'=>'0',
            'is_extraimages'=>'1',
            'is_vacancy'=>'2',
            'total_rooms'=>'6',
        ]);

        Rental_house::create([
            'rental_name'=>'AllLandlordsHouse',
            'rental_slug'=>'landlords_house',
            'monthly_rent'=>'1',
            'rental_address'=>'karanja street,Skuta',
            'rental_details'=>'am the description for the Landlords',
            'rental_image'=>'LandlordsHouse.png',
            'rentalcat_id'=>'1',
            'rental_status'=>'1',
            'is_rentable'=>'0',
            'location_id'=>'1',
            'landlord_id'=>'0',
            'is_extraimages'=>'1',
            'is_vacancy'=>'1',
            'total_rooms'=>'200',
        ]);

    }
}
