<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seller_id' => User::factory(),
            'category_id' => 23,
            'visible' => 1,
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->name),
            'description' => $this->faker->realText(),
            'price' => $this->faker->randomNumber(2),
            'discount_type' => $this->faker->boolean,
            'discount_price' => $this->faker->randomNumber(2)
        ];
    }

    public function hasDiscount()
    {
        return $this->state([
            'discount_type' => $this->faker->boolean,
            'discount_price' => $this->faker->randomNumber(2)
        ]);
    }
}
