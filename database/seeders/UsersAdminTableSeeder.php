<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'full_name' => 'th1@mail.ru',
            'customer_code' => 'A2324242',
            'ip_address' => '21432423432',
            'phone_number' => '2133242324',
            'email' => 'th1@mail.ru',
            'password' => bcrypt('123456789'),
        ]);
        $user->assignRole('admin');
    }
}
