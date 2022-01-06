<?php

namespace Database\Factories\Setup;

use App\Models\Setup\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;


    public function definition()
    {
        for ($i=1; $i < 10; $i++) {
            $num[] = $i;
        }
        return [
            // 'supplier_id' => $this->faker->randomElement($num),
            // 'school_id' => $this->faker->randomElement($num),
            'publisher_id' => $this->faker->randomElement($num),
            'location_id' => $this->faker->randomDigitNotNull(),
            'warehouse_id' => $this->faker->randomElement([1,2,3,4,5]),
            'name' => $this->faker->unique()->firstName() . ' Book',
            'subject' => $this->faker->randomElement(['Math', 'Science', 'English', 'Hindi', 'SST', 'Phyiscs', 'Chemistry', 'Biology','Accounts','Ip','Computer Basis','Hindi II','Economics','Political Science','Sociology', 'Psychology', "History", 'Civics', 'Geogrophy', 'Art', 'Hindi Shahetya', 'Hindi Viyakaran', 'English Listrature', 'English Grammer', 'Philosophy', 'Anthropology', 'Earth Sciences', 'Life Sciences', 'Physics', 'Space Sciences', 'Logic', 'Mathematics', 'Statistics', 'Systems Science', 'Agriculture', 'Architecture and Design', 'Business', 'Divinity', 'Education','Engineering', 'Family and Consumer Science', 'Health Sciences', 'Law', 'Journalism, Media Studies and Communication','Military Sciences', 'Public Administration', 'Social Work', 'Transportation']),
            'author_name' => $this->faker->name(),
            'description' => 'Some rendome description for system invoice.',
            'class' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th', '5th' , '6th', '7th', '8th', '9th', '10th', '11th science', '12th science', '11th arts', '12th arts']),
            'note' => 'Some rendome note for system admin and operators.',
            'quantity' => $this->faker->numberBetween(0,50),
            'sku_no' => $this->faker->unique()->numberBetween(10000,99999),
            'active' => true
        ];
    }
}
