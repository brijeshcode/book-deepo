<?php

namespace Database\Factories\Setup;

use App\Models\Setup\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    protected $model = Publisher::class;
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
            'location_id' => $this->faker->randomDigitNotNull(),
            'name' => $this->faker->firstName() . ' Publications',
            'address' => $this->faker->address(),
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
