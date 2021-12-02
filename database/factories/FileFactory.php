<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_images = ['product-1.jpg','product-2.jpg','product-3.png','product-4.jpg'];
        $image =  $product_images[rand(0,3)];
        return [
            'name' => $image,
            'model_type' => 'App\Models\Product',
            'model_id' => Product::all()->random(1)->first()->id
        ];
    }
}
