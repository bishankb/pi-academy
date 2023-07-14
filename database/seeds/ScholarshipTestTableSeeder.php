<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\ScholarshipTest;

class ScholarshipTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();
        
        foreach (range(1, config('pi-academy.seed_number')) as $index) {
            ScholarshipTest::create(
                [
                    //Personal Detail
                    'first_name' => $faker->word,
                    'last_name' => $faker->word,
                    'gender' => rand(0,1),
                    'landline_number' => '061521853',
                    'cell_number' => '9846758580',
                    'email' => $faker->email,
                    'permanent_address' => $faker->word,
                    'district' => $faker->word,
                    'municipality' => $faker->word,

                    //Academic Qualification
                    'education_level' => rand(0,3),
                    
                    //College        
                    'college_name' => $faker->word,
                    'college_address' => $faker->word,

                    //School
                    'school_name' => $faker->word,
                    'school_address' => $faker->word,

                    //PI Academic Reference
                    'registration_number' => $faker->word,
                    'interested_course' => rand(0, 6),
                    'shift' => rand(0, 2),

                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
