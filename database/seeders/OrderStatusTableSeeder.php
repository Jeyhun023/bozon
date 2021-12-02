<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['title' => 'Gözlənilir'],
            ['title' => 'Təsdiqləndi'],
            ['title' => 'Kuryerdə'],
            ['title' => 'Təhvil verildi'],
            ['title' => 'Ləğv edildi'],
        ];
        DB::table('order_statuses')->insert($statuses);
    }
}
