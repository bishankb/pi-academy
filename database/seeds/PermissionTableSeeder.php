<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboard',
            'user',
            'role',
            'transaction',
            'scholarship_test',
            'visitor',
            'student_registration',
            'student_payment_history',
            'attendence',
            'question_set',
            'examination_question',
            'routine_group',
            'routine_class_time',
            'routine',
            'meeting',
            'client'
        ];

        foreach ($permissions as $key => $permission) {
        	Artisan::call('crescent:auth:permission', ['name' => $permission]);
        }

    }
}
