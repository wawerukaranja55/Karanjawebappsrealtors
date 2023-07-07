<?php

namespace Database\Factories;

use App\Models\Rental_house;
use Illuminate\Database\Eloquent\Factories\Factory;

class Rental_houseFactory extends Factory
{
    protected $model = Rental_house::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rental_name'=>$this->faker->unique(5)->company(),
            'rental_slug'=>$this->faker->unique(5)->company(),
            'rental_address'=>$this->faker->unique(5)->company(),
            'monthly_rent'=>$this->faker->numberBetween(5000, 40000),
            'rental_details'=>$this->faker->paragraphs(2, true),
            'rental_image'=>$this->faker->unique(5)->company(),
            'rentalcat_id'=>$this->faker->numberBetween(1, 2),
            'location_id'=>$this->faker->numberBetween(1, 6),
            'landlord_id'=>$this->faker->numberBetween(1, 3),
            'is_rentable'=>1,
            'is_addedtags'=>1,
            'is_extraimages'=>1,
            'total_rooms'=>$this->faker->numberBetween(1, 7),
            'wifi'=>$this->faker->randomElement(['yes', 'no']),
            'generator'=>$this->faker->randomElement(['yes', 'no']),
            'balcony'=>$this->faker->randomElement(['yes', 'no']),
            'parking'=>$this->faker->randomElement(['yes', 'no']),
            'cctv_cameras'=>$this->faker->randomElement(['yes', 'no']),
            'servant_quarters'=>$this->faker->randomElement(['yes', 'no']),
        ];
    }
}
