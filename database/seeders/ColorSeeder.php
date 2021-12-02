<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            ['name' => 'Qara', 'code' => '#000000'],
            ['name' => 'Bej', 'code' => '#A52A2A	'],
            ['name' => 'Qəhvəyi', 'code' => '#3c49c3'],
            ['name' => 'Xaki', 'code' => '#f0e68c'],
            ['name' => 'Mavi', 'code' => '	#0000FF'],
            ['name' => 'Ağ', 'code' => '#FFFFFF'],
            ['name' => 'Tünd Göy', 'code' => '#000080'],
            ['name' => 'Sarı', 'code' => '#FFFF00'],
            ['name' => 'Yaşıl', 'code' => '#008000'],
            ['name' => 'Qırmızı', 'code' => '#FF0000'],
        ]);
    }
}
