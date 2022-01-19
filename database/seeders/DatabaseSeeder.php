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
        Location::query()->truncate();
        Warehouse::query()->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        School::query()->truncate();
        Supplier::query()->truncate();
        Publisher::query()->truncate();
        Book::query()->truncate();

        //
        User::query()->truncate();
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        //
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // User::factory(3)->create();
        Location::factory(10)->create();
        Warehouse::factory(5)->create();
        School::factory(50)->create();
        Supplier::factory(50)->create();
        Publisher::factory(50)->create();
        // Book::factory(5)->create();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
