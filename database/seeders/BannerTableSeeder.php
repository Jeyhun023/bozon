<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            ['title' => 'lorem ipsum sit amet','thumb_image' => 'banner-logo-1.jpg','main_image' => 'banner-1.jpg','url' =>'https://www.schoen.com/','visible' => 1],
            ['title' => 'lorem ipsum sit amet','thumb_image' => 'banner-logo-2.jpg','main_image' => 'banner-2.jpg','url' =>'https://www.schoen.com/','visible' => 1],
            ['title' => 'lorem ipsum sit amet','thumb_image' => 'banner-logo-1.jpg','main_image' => 'banner-1.jpg','url' =>'https://www.schoen.com/','visible' => 1],
            ['title' => 'lorem ipsum sit amet','thumb_image' => 'banner-logo-2.jpg','main_image' => 'banner-3.jpg','url' =>'https://www.schoen.com/','visible' => 1],
        ];
        DB::table('banners')->insert($banners);
    }
}
