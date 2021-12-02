<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AboutUsSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersAdminTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(BannerTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(AttributeTableSeeder::class);
         User::factory(2)->has(
             Product::factory()
             ->count(5)
         )->create();

         File::factory(60)->create();
    }
}
