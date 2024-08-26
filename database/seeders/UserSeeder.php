<?php

namespace Database\Seeders;

use App\Models\Statistika;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name'=>"Admin",
           'email' =>'admin@gmail.com',
            "role"=>"admin",
            'password'=>Hash::make('password')
        ]);
        User::create([
            'name'=>"Barmen",
            'email' =>'barmen@gmail.com',
            "role"=>"barmen",
            'password'=>Hash::make('bar1234')
        ]);
        Statistika::create([
            'date'=>date('Y-m-d',strtotime('-1 day')),
            'total_debt'=>0,
            'received_debt'=>0,
            'paid_debt'=>0,
            'debtors_count'=>0,
        ]);

    }
}
