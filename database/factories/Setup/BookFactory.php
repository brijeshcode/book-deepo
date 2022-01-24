<?php

namespace Database\Factories\Setup;

use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;


    public function definition()
    {
        /*$location[1]  = [1,2,3];
        $location[2]  = [4,5,6];*/
        $locations = Location::count();
        $limit = 3;
        $location = $this->faker->numberBetween(1,$locations);
        $max = $location * $limit;
        // $min = (($location - 1) * $limit ) + 1 ;
        $min = $max - $limit + 1;

        $publisher = $this->faker->numberBetween($min , $max);
        $warehouse = $this->faker->numberBetween($min , $max);
        /*$publisher = $this->faker->randomElement($location[$temploc]);
        $warehouse = $this->faker->randomElement($location[$temploc]);*/
        return [

            'publisher_id' => $publisher,
            'warehouse_id' => $warehouse,
            'location_id' => $location,

            'name' => $this->faker->unique()->firstName() . ' Book',
            'subject' => $this->faker->randomElement(['Math', 'Science', 'English', 'Hindi', 'SST', 'Phyiscs', 'Chemistry', 'Biology','Accounts','Ip','Computer Basis','Hindi II','Economics','Political Science','Sociology', 'Psychology', "History", 'Civics', 'Geogrophy', 'Art', 'Hindi Shahetya', 'Hindi Viyakaran', 'English Listrature', 'English Grammer', 'Philosophy', 'Anthropology', 'Earth Sciences', 'Life Sciences', 'Physics', 'Space Sciences', 'Logic', 'Mathematics', 'Statistics', 'Systems Science', 'Agriculture', 'Architecture and Design', 'Business', 'Divinity', 'Education','Engineering', 'Family and Consumer Science', 'Health Sciences', 'Law', 'Journalism, Media Studies and Communication','Military Sciences', 'Public Administration', 'Social Work', 'Transportation']),
            'author_name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'class' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th', '5th' , '6th', '7th', '8th', '9th', '10th', '11th science', '12th science', '11th arts', '12th arts']),
            'note' =>  $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(0,50),
            'sku_no' => $this->faker->unique()->numberBetween(10000,99999),
            'active' => true
        ];
    }
}
