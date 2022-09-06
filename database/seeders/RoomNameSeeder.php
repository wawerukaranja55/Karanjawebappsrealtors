<?php

namespace Database\Seeders;

use App\Models\Room_name;
use Illuminate\Database\Seeder;

class RoomNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'1','is_occupied'=>'1']);
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'2','is_occupied'=>'1']);
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'3','is_occupied'=>'1']);
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'4','is_occupied'=>'1']);
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'5','is_occupied'=>'1']);
        Room_name::create(['rentalhouse_id'=>'1','room_name'=>'6','is_occupied'=>'1']);
    }
}