<?php

namespace Database\Seeders;

use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Database\Seeder;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset
        /*Location::query()->truncate();
        Warehouse::query()->truncate();
        Supplier::query()->truncate();
        Publisher::query()->truncate();
        School::query()->truncate();
        Book::query()->truncate();*/

        // seed
        Location::factory(20)
        ->has(Warehouse::factory()->count(3)->has(School::factory(2)))
        ->has(Publisher::factory()->count(3))
        ->has(Supplier::factory()->count(3))
        ->create();


        $books = Book::factory(500)->create();
        $bookSchool = $bookSupplier = array();
        foreach ($books as $key => $book) {

            $bookSchool[] = [
                    'book_id' => $book->id,
                    'school_id' => $book->warehouse->schools()->first()->id,
                ];
            $bookSupplier[] = [
                    'book_id' => $book->id,
                    'supplier_id' => $book->location->suppliers()->first()->id,
                ];
        }
        // dd($bookSupplier);
        DB::table('book_school')->truncate();
        DB::table('book_supplier')->truncate();
        DB::table('book_school')->insert( $bookSchool);
        DB::table('book_supplier')->insert( $bookSupplier);
    }
}
