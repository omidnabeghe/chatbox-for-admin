<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'alfred',
            'email' => 'alfred@gmail.com',
            'password' => Hash::make('123'),
            'user_type' =>1,
        ]);

    }
}
