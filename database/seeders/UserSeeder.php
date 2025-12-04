<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kasun Silva',
            'email' => 'kasun5@gmail.com',
            'phone' => '0765221472',
            'address' => '123 Main St',
        ]);

        User::create([
            'name' => 'Malshi Perera',
            'email' => 'pereramal@gmail.com',
            'phone' => '0777521488',
            'address' => 'No.456 Kochchikade, Negombo',
        ]);

        User::create([
            'name' => 'Savindu fernando',
            'email' => 'savi18fdo@gmail.com',
            'phone' => '0716353417',
            'address' => '233/B, Colombo 2',
        ]);
    }
}
