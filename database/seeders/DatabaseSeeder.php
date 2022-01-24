<?php

namespace Database\Seeders;

use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use App\Models\User;
use DB;
use Database\Seeders\LocationSeeder;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // User::query()->truncate();
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);

        Location::query()->truncate();
        Warehouse::query()->truncate();
        Supplier::query()->truncate();
        Publisher::query()->truncate();
        School::query()->truncate();
        Book::query()->truncate();

        $this->call(LocationSeeder::class);
        $this->call(LocationSeeder::class);
        /*$this->call(LocationSeeder::class);
        $this->call(LocationSeeder::class);*/

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }
}
