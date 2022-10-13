<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Room_name;
use App\Models\Tenantstatus;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\Userseeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\Rentaltagseeder;
use Database\Seeders\RoomnumberSeeder;
use Database\Seeders\RentalhouseSeeder;
use Database\Seeders\LocationtypeSeeder;
use Database\Seeders\TenantstatusSeeder;
use Database\Seeders\VacancyStatusSeeder;
use Database\Seeders\RentalCategorySeeder;
use Database\Seeders\Propertycategoryseeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RentalCategorySeeder::class);
        $this->call(PaymentTransactiontypeSeeder::class);

        $this->call(RoomNameSeeder::class);
        $this->call(Rentaltagseeder::class);
        $this->call(TenantstatusSeeder::class);
        
        $this->call(VacancyStatusSeeder::class);

        $this->call(Propertycategoryseeder::class);

        $this->call(LocationSeeder::class);

        $this->call(RentalhouseSeeder::class);

        $this->call([
            RoleSeeder::class,
            Userseeder::class,
        ]);
        Tenantstatus::factory()->create();
        Role::factory()->create();
        Room_name::factory()->count(100)->create();
    }
}
