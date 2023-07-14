<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 1, 
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1
            ]
        );

        User::create(
            [
                'name'           => 'Bishank Badgami',
                'email'          => 'bishank@bishank.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 2,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );
        
        User::create(
            [
                'name'           => 'Manoj Kumar Agrahari',
                'email'          => 'manoj@manoj.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Sunil Shrestha',
                'email'          => 'sunil@sunil.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Bishad Man Gubhaju',
                'email'          => 'bishad@bishad.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Surya Poudel',
                'email'          => 'surya@surya.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Sushant Malla',
                'email'          => 'sushant@sushant.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Deepak Bastakoti',
                'email'          => 'deepak@deepak.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Pranit Malla',
                'email'          => 'pranit@pranit.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );

        User::create(
            [
                'name'           => 'Sumit Shrestha',
                'email'          => 'sumit@sumit.com',
                'password'       => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role_id'        => 3,
                'active'         => true,
                'created_by'     => 1,
                'updated_by'     => 1,     
            ]
        );
    }
}
