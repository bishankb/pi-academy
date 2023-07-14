<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('staff_id');
            $table->date('english_attendence_date');
            $table->string('nepali_attendence_date');
            $table->boolean('has_taken_leave')->default(0);
            $table->string('leave_reason')->nullable();
            $table->boolean('is_holiday')->default(0);
            $table->string('holiday_reason')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('departure_time')->nullable();
            $table->boolean('has_taken_gap')->default(0);
            $table->string('gap_departure_time')->nullable();
            $table->string('gap_arrival_time')->nullable();
            $table->string('gap_reason')->nullable();
            $table->unsignedInteger('worked_hour')->default(0);
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
        Schema::dropIfExists('attendences');
    }
}
