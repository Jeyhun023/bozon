<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categoryData() as $category) {
            $category['slug'] = Str::slug($category['name']);
            Category::create($category);
        }
    }

    private function categoryData()
    {
        return array(
            array('id' => '1','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Texnika və elektronika'),
            array('id' => '2','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Məişət texnikası'),
            array('id' => '3','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Ayaqqabılar'),
            array('id' => '4','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Geyim, aksesuarlar'),
            array('id' => '5','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Uşaq dünyası'),
            array('id' => '6','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Mebel'),
            array('id' => '7','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Ev və bağ təchizatı'),
            array('id' => '8','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'Gözəllik və sağlamlıq'),
            array('id' => '9','banner' => 'category-1.jpg','parent_id' => '0','visible' => '1','name' => 'İdman malları'),
            array('id' => '10','parent_id' => '1','visible' => '1','name' => 'Kompüter avadanlıqları, Aksesuarlar'),
            array('id' => '11','parent_id' => '1','visible' => '1','name' => 'Televizorlar, Audio, Video'),
            array('id' => '12','parent_id' => '1','visible' => '1','name' => 'Foto, videokamera, Aksesuarlar'),
            array('id' => '13','parent_id' => '1','visible' => '1','name' => 'Təhlükəsizlik və müdafiə'),
            array('id' => '14','parent_id' => '10','visible' => '1','name' => 'Noutbuklar üçün akkumulyatorlar'),
            array('id' => '15','parent_id' => '10','visible' => '1','name' => 'Server avadanlığı'),
            array('id' => '16','parent_id' => '10','visible' => '1','name' => 'Noutbuklar'),
            array('id' => '18','parent_id' => '2','visible' => '1','name' => 'Böyük məişət texnikası'),
            array('id' => '19','parent_id' => '2','visible' => '1','name' => 'Ev üçün məişət texnikası'),
            array('id' => '20','parent_id' => '2','visible' => '1','name' => 'Hava tənzimləyici cihazlar'),
            array('id' => '21','parent_id' => '2','visible' => '1','name' => 'Mətbəx üçün kiçik məişət texnikası'),
            array('id' => '22','parent_id' => '2','visible' => '1','name' => 'Ev üçün digər məişət texnikası'),
            array('id' => '23','parent_id' => '2','visible' => '1','name' => 'Texnika üçün ehtiyat hissələri və aksesuarlar'),
            array('id' => '24','parent_id' => '3','visible' => '1','name' => 'Qadın ayaqqabıları'),
            array('id' => '25','parent_id' => '3','visible' => '1','name' => 'Kişi ayaqqabıları'),
            array('id' => '26','parent_id' => '3','visible' => '1','name' => 'Qızlar üçün ayaqqabılar'),
            array('id' => '27','parent_id' => '3','visible' => '1','name' => 'Oğlanlar üçün ayaqqabılar'),
            array('id' => '28','parent_id' => '3','visible' => '1','name' => 'İdman və aktiv istirahət üçün ayaqqabı'),
            array('id' => '29','parent_id' => '3','visible' => '1','name' => 'Ayaqqabı üçün aksesuarlar')
        );
    }
}
