<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScholarshipTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarship_tests', function (Blueprint $table) {
            $table->increments('id');
            
            //Personal Detail
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedInteger('gender');
            $table->date('english_dob')->nullable();
            $table->string('nepali_dob')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('cell_number')->nullable();
            $table->string('email')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('district')->nullable();
            $table->string('municipality')->nullable();
            $table->unsignedInteger('student_image_id')->nullable();

            //Contact Address(If different from honme address)
            $table->string('current_address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_landline_number')->nullable();
            $table->string('guardian_cell_number')->nullable();

            //Academic Qualification
            //College
            $table->unsignedInteger('education_level')->nullable();
            $table->string('college_name')->nullable();
            $table->string('college_address')->nullable();
            $table->string('college_marks_obtained')->nullable();

            //School
            $table->string('school_name')->nullable();
            $table->string('school_address')->nullable();
            $table->string('school_marks_obtained')->nullable();

            //PI Academic Reference
            $table->string('registration_number')->nullable();
            $table->unsignedInteger('interested_course');
            $table->unsignedInteger('shift')->nullable();
            
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
        Schema::dropIfExists('scholarship_tests');
    }
}
