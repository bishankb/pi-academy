<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\carbon;
use App\QuestionSet;

class QuestionSetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();

        QuestionSet::create(
            [
                'name'       => 'Set 1',
                'slug'       => str_slug('Set 1'),
                'order'      => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        QuestionSet::create(
            [
                'name'       => 'Set 2',
                'slug'       => str_slug('Set 2'),
                'order'      => 2,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        QuestionSet::create(
            [
                'name'       => 'Set 3',
                'slug'       => str_slug('Set 3'),
                'order'      => 3,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        QuestionSet::create(
            [
                'name'       => 'Set 4',
                'slug'       => str_slug('Set 4'),
                'order'      => 4,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        QuestionSet::create(
            [
                'name'       => 'Set 5',
                'slug'       => str_slug('Set 5'),
                'order'      => 5,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
