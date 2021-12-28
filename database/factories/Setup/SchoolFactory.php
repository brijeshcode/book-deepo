<?php

namespace Database\Factories\Setup;

use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    protected $model = School::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $states = ['AR' => 'Arunachal Pradesh',
            'AR' => 'Arunachal Pradesh',
            'AS' => 'Assam',
            'BR' => 'Bihar',
            'CT' => 'Chhattisgarh',
            'GA' => 'Goa',
            'GJ' => 'Gujarat',
            'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh',
            'JK' => 'Jammu and Kashmir',
            'JH' => 'Jharkhand',
            'KA' => 'Karnataka',
            'KL' => 'Kerala',
            'MP' => 'Madhya Pradesh',
            'MH' => 'Maharashtra',
            'MN' => 'Manipur',
            'ML' => 'Meghalaya',
            'MZ' => 'Mizoram',
            'NL' => 'Nagaland',
            'OR' => 'Odisha',
            'PB' => 'Punjab',
            'RJ' => 'Rajasthan',
            'SK' => 'Sikkim',
            'TN' => 'Tamil Nadu',
            'TG' => 'Telangana',
            'TR' => 'Tripura',
            'UP' => 'Uttar Pradesh',
            'UT' => 'Uttarakhand',
            'WB' => 'West Bengal',
            'AN' => 'Andaman and Nicobar Islands',
            'CH' => 'Chandigarh',
            'DN' => 'Dadra and Nagar Haveli',
            'DD' => 'Daman and Diu',
            'LD' => 'Lakshadweep',
            'DL' => 'National Capital Territory of Delhi',
            'PY' => 'Puducherry'
        ];
        // $school name
        return [
            'warehouse_id' => $this->faker->randomElement([1,2,3,4,5]),
            'name' => $this->faker->firstName() . ' Public School',
            'city' => $this->faker->city(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'state' => $this->faker->randomElement($states),
            'contact_person' => $this->faker->name(),
            'pincode' => $this->faker->randomNumber(6),
            'note' => $this->faker->realText(30, 2),
            'actor_ip' => $this->faker->ipv4(),
            'active' => true
        ];
    }
}
