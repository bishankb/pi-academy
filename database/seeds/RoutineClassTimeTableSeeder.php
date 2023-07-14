<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\carbon;
use App\RoutineClassTime;

class RoutineClassTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();

        foreach (range(1, 7) as $key => $index) {
            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('6:15 AM'),
                    'class_end_time' => Carbon::parse('7:15 AM'),
                    'order' => 1,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('7:15 AM'),
                    'class_end_time' => Carbon::parse('8:15 AM'),
                    'order' => 2,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('8:40 AM'),
                    'class_end_time' => Carbon::parse('9:40 AM'),
                    'order' => 3,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('9:40 AM'),
                    'class_end_time' => Carbon::parse('10:40 AM'),
                    'order' => 4,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );
        }

        foreach (range(8, 9) as $key => $index) {
            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('11:00 AM'),
                    'class_end_time' => Carbon::parse('12:00 AM'),
                    'order' => 1,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('12:00 PM'),
                    'class_end_time' => Carbon::parse('1:00 PM'),
                    'order' => 2,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('1:20 PM'),
                    'class_end_time' => Carbon::parse('2:20 PM'),
                    'order' => 3,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );

            RoutineClassTime::create(
                [
                    'group_id' => $index,
                    'class_start_time' => Carbon::parse('2:20 PM'),
                    'class_end_time' => Carbon::parse('3:20 PM'),
                    'order' => 4,
                    'created_by' => 1,
                    'updated_by' =>1 
                ]
            );
        }
    }
}