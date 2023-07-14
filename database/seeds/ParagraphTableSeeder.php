<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Paragraph;
use App\QuestionSet;

class ParagraphTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();

        $totalSet = QuestionSet::count();
        
        foreach (range(1, $totalSet) as $index) {
            Paragraph::create(
                [
                    'question_set_id' => $index,
                    'paragraph' => $faker->word
                ]
            );
        }
    }
}
