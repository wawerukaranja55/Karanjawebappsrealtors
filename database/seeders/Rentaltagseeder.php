<?php

namespace Database\Seeders;

use App\Models\Rental_tags;
use Illuminate\Database\Seeder;

class Rentaltagseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rentaltags=[
            ['id'=>1,'rentaltag_title'=>'1 bedroom','status'=>'1'],
            ['id'=>2,'rentaltag_title'=>'2 bedroom','status'=>'1'],
            ['id'=>3,'rentaltag_title'=>'3 bedroom','status'=>'1'],
            ['id'=>4,'rentaltag_title'=>'family home','status'=>'1'],
            ['id'=>5,'rentaltag_title'=>'apartment','status'=>'1'],
            ['id'=>6,'rentaltag_title'=>'singleroom','status'=>'1'],
            ['id'=>7,'rentaltag_title'=>'bedsitter','status'=>'1'],
            ['id'=>8,'rentaltag_title'=>'hostel','status'=>'1'],
            ['id'=>9,'rentaltag_title'=>'office spaces','status'=>'1'],
            ['id'=>10,'rentaltag_title'=>'shop spaces','status'=>'1'],
            ['id'=>11,'rentaltag_title'=>'stalls','status'=>'1']
        ];

        Rental_tags::insert($rentaltags);
    }
}
