<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examination_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('question_set_id');
            $table->unsignedInteger('attempted_1_mark');
            $table->unsignedInteger('attempted_2_mark');
            $table->unsignedInteger('correct_1_mark');
            $table->unsignedInteger('correct_2_mark');
            $table->unsignedInteger('attempted');
            $table->double('score');
            $table->text('attempted_questions');
            $table->text('choosen_answers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examination_results');
    }
}
