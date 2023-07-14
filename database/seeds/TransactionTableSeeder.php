<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\carbon;
use App\Transaction;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Faker::create();
        
        foreach (range(1, config('pi-academy.seed_number')) as $index) {
            Transaction::create(
                [
                    'transaction_id'           => mt_rand(10000, mt_getrandmax()),
                    'transaction_type'         => 0,
                    'english_transaction_date' => '2018-12-31',
                    'nepali_transaction_date'  => '2076-12-31',
                    'transaction_time'         => '09:30:25 AM',
                    'payment_amount'           => 25000,
                    'payment_type'             => 0,
                    'expend_by'                => 1,
                    'remarks'                  => 'Nice one',        
                    'created_by'               => 1,        
                    'updated_by'               => 1,   
                ]
            );
        }
    }
}
