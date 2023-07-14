<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutineClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_time_id');
            $table->unsignedInteger('routine_id')->nullable();
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject');
            $table->text('topic_taught');
            $table->boolean('is_empty')->nullable();
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
        Schema::dropIfExists('routine_classes');
    }
}
