<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'property_name'=>$this->faker->unique(5)->company(),
            'property_slug'=>$this->faker->unique(5)->company(),
            'property_address'=>$this->faker->unique(5)->company(),
            'property_price'=>$this->faker->numberBetween(5000, 40000),
            'property_details'=>$this->faker->paragraphs(2, true),
            'property_image'=>$this->faker->unique(5)->company(),
            'propertycat_id'=>$this->faker->numberBetween(1, 4),
            'propertylocation_id'=>$this->faker->numberBetween(1, 8),
            'property_isactive'=>1,
        ];
    }
}
