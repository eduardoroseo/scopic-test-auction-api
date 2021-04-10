<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->randomFloat(2, 5, 50);

        return [
            'name' => Str::title($this->faker->words(3, true)),
            'description' => $this->faker->realText(),
            'start_price' => $price,
            'price' => $price,
        ];
    }
}
