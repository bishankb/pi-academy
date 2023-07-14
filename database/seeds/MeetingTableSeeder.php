<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Meeting;

class MeetingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();
        
        Meeting::create(
            [
                'topic'                => $faker->word,
                'english_meeting_date' => '2019-06-04',
                'nepali_meeting_date'  => '2076-02-21',
                'meeting_start_time'   => '09:00:25 AM',
                'meeting_end_time'     => '01:00:25 PM',
                'discussed'            => $faker->word,
                'created_by'           => 1,
                'updated_by'           => 1
            ]
        );

        Meeting::create(
            [
                'topic'                => $faker->word,
                'english_meeting_date' => '2019-06-05',
                'nepali_meeting_date'  => '2076-02-22',
                'meeting_start_time'   => '08:00:25 AM',
                'meeting_end_time'     => '02:00:25 PM',
                'discussed'            => $faker->word,
                'created_by'           => 1,
                'updated_by'           => 1
            ]
        );

        Meeting::create(
            [
                'topic'                => $faker->word,
                'english_meeting_date' => '2019-06-06',
                'nepali_meeting_date'  => '2076-02-23',
                'meeting_start_time'   => '11:00:25 AM',
                'meeting_end_time'     => '04:00:25 PM',
                'discussed'            => $faker->word,
                'created_by'           => 1,
                'updated_by'           => 1
            ]
        );

        Meeting::create(
            [
                'topic'                => $faker->word,
                'english_meeting_date' => '2019-06-07',
                'nepali_meeting_date'  => '2076-02-24',
                'meeting_start_time'   => '09:00:25 AM',
                'meeting_end_time'     => '01:00:25 PM',
                'discussed'            => $faker->word,
                'created_by'           => 1,
                'updated_by'           => 1
            ]
        );

        Meeting::create(
            [
                'topic'                => $faker->word,
                'english_meeting_date' => '2019-06-08',
                'nepali_meeting_date'  => '2076-02-25',
                'meeting_start_time'   => '11:00:25 AM',
                'meeting_end_time'     => '04:00:25 PM',
                'discussed'            => $faker->word,
                'created_by'           => 1,
                'updated_by'           => 1
            ]
        );
    }
}
