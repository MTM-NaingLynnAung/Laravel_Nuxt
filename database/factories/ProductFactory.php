<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fakerFileName = $this->faker->image(
            storage_path("app/public/images"),
            100,
            100
        );
        $filePath = storage_path('images');
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(100, 300),
            'image' => 'images/Testing.jpg'
        ];
    }
}
