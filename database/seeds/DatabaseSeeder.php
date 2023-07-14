<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(ScholarshipTestTableSeeder::class);
        $this->call(VisitorTableSeeder::class);
        $this->call(StudentRegistrationTableSeeder::class);
        $this->call(QuestionSetTableSeeder::class);
        $this->call(ExaminationQuestionTableSeeder::class);
        $this->call(ParagraphTableSeeder::class);
        $this->call(RoutineGroupTableSeeder::class);
        $this->call(RoutineClassTimeTableSeeder::class);
        $this->call(MeetingTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(SinglePermissionTableSeeder::class);
    }
}
