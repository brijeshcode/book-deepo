<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
            [
                'name' => "Admin",
                'email' => 'admin@phoeniixx.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Brijesh",
                'email' => 'brijesh@phoeniixx.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test'),
                'remember_token' => Str::random(10),
            ],
        );


    }
}
