<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'Trend Alaçatı Stili','logo' => 'brand.png','slug' => 'brands-1','visible' => 1],
            ['name' => 'Lafaba','logo' => 'brand.png','slug' => 'brands-2','visible' => 1],
            ['name' => 'Dilvin','logo' => 'brand.png','slug' => 'brands-3','visible' => 1],
            ['name' => 'Kaktüs','logo' => 'brand.png','slug' => 'brands-4','visible' => 1],
        ];
        DB::table('brands')->insert($brands);
    }
}
