<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\StudentRegistration;
use App\OnlineExaminationCredential;

class StudentRegistrationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();

        $total_fee = rand(5000, 12000);
        $scholarship = 50;
        $fee_after_scholarship = $total_fee  - ( $scholarship / 100 * $total_fee);

        $student_registration1 = StudentRegistration::create(
            [
                //Personal Detail
                'first_name' => 'bishal',
                'last_name' => 'bishal',
                'gender' => 1,
                'email' => 'bishal@bishal.com',

                //Fee
                'total_fee' => $total_fee,
                'scholarship' => $scholarship,
                'fee_after_scholarship' => $fee_after_scholarship,

                'registration_number' => $faker->word,
                'interested_course' => rand(0, 6),
                'shift' => rand(0, 2),
                'interested_stream' => $faker->word,
                'approved_by' => $faker->word,

                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        $student_registration2 = StudentRegistration::create(
            [
                //Personal Detail
                'first_name' => 'sushank',
                'middle_name' => 'kumar',
                'last_name' => 'gurung',
                'gender' => 1,
                'email' => 'sushank@sushank.com',

                //Fee
                'total_fee' => $total_fee,
                'scholarship' => $scholarship,
                'fee_after_scholarship' => $fee_after_scholarship,

                'registration_number' => $faker->word,
                'interested_course' => rand(0, 6),
                'shift' => rand(0, 2),
                'interested_stream' => $faker->word,
                'approved_by' => $faker->word,

                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        $student_registration3 = StudentRegistration::create(
            [
                //Personal Detail
                'first_name' => 'sabin',
                'last_name' => 'sabin',
                'gender' => 1,
                'email' => 'sabin@sabin.com',

                //Fee
                'total_fee' => $total_fee,
                'scholarship' => $scholarship,
                'fee_after_scholarship' => $fee_after_scholarship,

                'registration_number' => $faker->word,
                'interested_course' => rand(0, 6),
                'shift' => rand(0, 2),
                'interested_stream' => $faker->word,
                'approved_by' => $faker->word,

                'created_by' => 1,
                'updated_by' => 1,
            ]
        );

        if(isset($student_registration1->middle_name)) {
            $username1 = $student_registration1->first_name . ' ' . $student_registration1->middle_name . ' ' . $student_registration1->last_name;
        } else {
            $username1 = $student_registration1->first_name . ' ' .$student_registration1->last_name;
        }

        if(isset($student_registration2->middle_name)) {
            $username2 = $student_registration2->first_name . ' ' . $student_registration2->middle_name . ' ' . $student_registration2->last_name;
        } else {
            $username2 = $student_registration2->first_name . ' ' .$student_registration2->last_name;
        }

        if(isset($student_registration3->middle_name)) {
            $username3 = $student_registration3->first_name . ' ' . $student_registration3->middle_name . ' ' . $student_registration3->last_name;
        } else {
            $username3 = $student_registration3->first_name . ' ' .$student_registration3->last_name;
        }

        OnlineExaminationCredential::create([
            'student_id'          => $student_registration1->id,
            'email'               => $student_registration1->email,
            'username'            => $username1,
            'password'            => bcrypt('secret'),
            'active'              => 1,
            'verified'       => 1,
            'registration_number' => $student_registration1->registration_number
        ]);

        OnlineExaminationCredential::create([
            'student_id'          => $student_registration2->id,
            'email'               => $student_registration2->email,
            'username'            => $username2,
            'password'            => bcrypt('secret'),
            'active'              => 1,
            'verified'            => 1,
            'registration_number' => $student_registration2->registration_number
        ]);

        OnlineExaminationCredential::create([
            'student_id'          => $student_registration3->id,
            'email'               => $student_registration3->email,
            'username'            => $username3,
            'password'            => bcrypt('secret'),
            'active'              => 1,
            'verified'            => 1,
            'registration_number' => $student_registration3->registration_number
        ]);
    }
}
