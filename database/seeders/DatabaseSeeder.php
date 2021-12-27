<?php

namespace Database\Seeders;

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
        Location::query()->truncate();
        School::query()->truncate();
        User::query()->truncate();
        Supplier::query()->truncate();
        Publisher::query()->truncate();
        Warehouse::query()->truncate();
        $this->call(UserSeeder::class);

        User::factory(10)->create();
        Location::factory(20)->create();
        School::factory(20)->create();
        Supplier::factory(40)->create();
        Publisher::factory(50)->create();
        Warehouse::factory(10)->create();
    }
}
