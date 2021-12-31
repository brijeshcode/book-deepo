<?php

namespace Database\Seeders;

use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*User::query()->truncate();
        Location::query()->truncate();
        Warehouse::query()->truncate();
        School::query()->truncate();
        Supplier::query()->truncate();
        Publisher::query()->truncate();*/
        Book::query()->truncate();
        // $this->call(UserSeeder::class);

        /*User::factory(3)->create();
        Location::factory(10)->create();
        Warehouse::factory(5)->create();
        School::factory(10)->create();
        Supplier::factory(10)->create();
        Publisher::factory(10)->create();*/
        Book::factory(500)->create();
    }
}
