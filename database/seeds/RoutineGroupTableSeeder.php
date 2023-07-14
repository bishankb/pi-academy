<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\carbon;
use App\RoutineGroup;

class RoutineGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();

        RoutineGroup::create(
            [
                'name'       => 'MT101',
                'shift'      => 0,
                'order'      => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'MT301',
                'shift'      => 0,
                'order'      => 2,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'MT303',
                'shift'      => 0,
                'order'      => 3,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'M305',
                'shift'      => 0,
                'order'      => 4,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'MT201',
                'shift'      => 0,
                'order'      => 5,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'MT203',
                'shift'      => 0,
                'order'      => 6,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'M205',
                'shift'      => 0,
                'order'      => 7,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'D101',
                'shift'      => 1,
                'order'      => 8,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'D301',
                'shift'      => 1,
                'order'      => 9,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );

        RoutineGroup::create(
            [
                'name'       => 'D305',
                'shift'      => 1,
                'order'      => 10,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
