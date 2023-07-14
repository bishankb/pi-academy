<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Visitor;

class VisitorTableSeeder extends Seeder
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
            Visitor::create(
                [
                    'name' => $faker->word,
                    'college_name' => $faker->word,
                    'marks_obtained' => 78,
                    'academic_status' => 1,
                    'counselled_by' => 2,
                    'is_registered' => rand(0, 1),
                    'accompanied_by' => $faker->word,
                    'interested_course' => rand(0, 6),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
