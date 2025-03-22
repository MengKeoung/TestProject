<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1, // Example ID, ensure this is unique or auto-incremented
            'name' => 'Meng Cooper', // Name of the user
            'email' => 'mengcooper@gmail.com', // Email of the user
            'password' => Hash::make('12345678'), // Encrypted password
        ]);
    }
}
