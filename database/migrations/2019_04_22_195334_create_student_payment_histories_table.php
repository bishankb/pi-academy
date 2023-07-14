<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->double('payment_amount');
            $table->date('english_payment_date');
            $table->string('nepali_payment_date');
            $table->string('payment_time')->nullable();
            $table->string('receipt_number');
            $table->unsignedInteger('received_by')->nullable();
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
        Schema::dropIfExists('student_payment_histories');
    }
}
