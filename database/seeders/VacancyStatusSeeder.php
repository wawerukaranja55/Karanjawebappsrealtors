<?php

namespace Database\Seeders;

use App\Models\Vacancy_status;
use Illuminate\Database\Seeder;

class VacancyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vacancystatus=[
            ['id'=>1,'vacancystatus_title'=>'Vacants Available','status'=>'1'],
            ['id'=>2,'vacancystatus_title'=>'Fully Booked','status'=>'1']
        ];

       Vacancy_status::insert($vacancystatus);
    }
}
