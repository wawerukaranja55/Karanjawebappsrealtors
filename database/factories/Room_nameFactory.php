<?php

namespace Database\Factories;

use App\Models\Room_name;
use Illuminate\Database\Eloquent\Factories\Factory;

class Room_nameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room_name::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rentalhouse_id'=>2,
            'status'=>1,
            'is_occupied'=>0,
            'is_roomsize'=>0,
            'room_name'=>$this->faker->numerify('landlord-##')
        ];
    }
}
