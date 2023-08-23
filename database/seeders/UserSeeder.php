<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
       
        $faker = Faker::create();

        
        for ($i = 0; $i < 100; $i++) {
            User::create([
                'ci' => $faker->unique()->randomNumber(8), 
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'), 
                'phone' => $faker->phoneNumber,
                'username' => $faker->userName,
            ]);
        }
    }
}

