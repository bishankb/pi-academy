<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Spatie\Permission\Models\Role::create(['display_name' => 'admin', 'name' => 'admin']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Developer', 'name' => 'developer']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Teacher', 'name' => 'teacher']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Share holders', 'name' => 'shareHolders']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Receptionist', 'name' => 'receptionist']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Counsellor', 'name' => 'counsellor']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Examination Department', 'name' => 'examdepart']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Cleaning Staff', 'name' => 'cleaningStaff']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Security guard', 'name' => 'securityGuard']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Auditor', 'name' => 'auditor']);
        Spatie\Permission\Models\Role::create(['display_name' => 'Accountant', 'name' => 'accountant']);        

        App\User::where('id', 1)->first()->assignRole('admin');
        App\User::where('id', 2)->first()->assignRole('counsellor');
        App\User::where('id', 3)->first()->assignRole('teacher');
        App\User::where('id', 4)->first()->assignRole('teacher');
        App\User::where('id', 5)->first()->assignRole('teacher');
        App\User::where('id', 6)->first()->assignRole('teacher');
        App\User::where('id', 7)->first()->assignRole('teacher');
        App\User::where('id', 8)->first()->assignRole('teacher');
        App\User::where('id', 9)->first()->assignRole('teacher');
        App\User::where('id', 10)->first()->assignRole('teacher');
    }
}