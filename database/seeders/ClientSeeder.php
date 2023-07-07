<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run()
    {
      
        User::create([
            'name' => 'Cliente de Prueba',
            'email' => 'cliente@prueba.com',
            'password' => bcrypt('password'),
        ]);

       
    }
}

