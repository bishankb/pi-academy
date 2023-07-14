<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('transaction_id')->unique();
            $table->unsignedInteger('transaction_type')->comment('Expenditure or Income');
            $table->date('english_transaction_date');
            $table->string('nepali_transaction_date');
            $table->string('transaction_time')->nullable();
            $table->unsignedInteger('payment_type')->comment('By Cash or Cheque');
            $table->double('payment_amount');
            $table->string('cheque_number')->nullable()->comment('Only If Payment By Cheque');
            $table->string('paid_by')->nullable()->comment('Only If Transaction is Income');
            $table->string('expend_by')->nullable()->comment('Only If Transaction is Expenditure');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
