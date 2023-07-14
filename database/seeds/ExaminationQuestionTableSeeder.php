<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\carbon;
use App\ExaminationQuestion;

class ExaminationQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();
        
        foreach (range(1, 3) as $set_index) {
            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 0,
                        'marks' => 0,
                        'question' => 'Aptitude Exam Question Marks 1',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 0,
                        'marks' => 1,
                        'question' => 'Aptitude Exam Question Marks 2',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 1,
                        'marks' => 0,
                        'question' => 'Chemistry Exam Question Marks 1',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 1,
                        'marks' => 1,
                        'question' => 'Chemistry Exam Question Marks 2',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 2,
                        'marks' => 0,
                        'question' => 'English Exam Question Marks 1',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 2,
                        'marks' => 1,
                        'question' => 'English Exam Question Marks 2',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 3,
                        'marks' => 0,
                        'question' => 'Math Exam Question Marks 1',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 3,
                        'marks' => 1,
                        'question' => 'Math Exam Question Marks 2',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 4,
                        'marks' => 0,
                        'question' => 'Physics Exam Question Marks 1',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }

            foreach (range(1, 10) as $index) {
                ExaminationQuestion::create(
                    [
                        'question_set_id' => $set_index,
                        'subject' => 4,
                        'marks' => 1,
                        'question' => 'Physics Exam Question Marks 2',
                        'option1' => $faker->word,
                        'option2' => $faker->word,
                        'option3' => $faker->word,
                        'option4' => $faker->word,
                        'correct_answer' => rand(0, 3),
                        'solution' => $faker->word,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]
                );
            }
        }
    }
}
