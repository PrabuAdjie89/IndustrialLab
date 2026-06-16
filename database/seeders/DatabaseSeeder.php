<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=> env('USER_NAME'),
            'email'=> env('USER_EMAIL'),
            'password'=> Hash::make(env('USER_PASSWORD')),
        ]);
    }
}
