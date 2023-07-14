<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
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
            //Documents
            $table->text('submitted_documents')->nullable();
            $table->unsignedInteger('student_image_1')->nullable();
            $table->unsignedInteger('student_image_2')->nullable();
            $table->unsignedInteger('character_certificate')->nullable();
            $table->unsignedInteger('scholarship_recommendation')->nullable();
            $table->unsignedInteger('marksheet')->nullable();

            //Fee
            $table->double('total_fee');
            $table->unsignedInteger('scholarship')->nullable();
            $table->double('fee_after_scholarship');
            $table->date('english_due_clearance_date')->nullable();
            $table->string('nepali_due_clearance_date')->nullable();

            $table->string('registration_number')->nullable();
            $table->unsignedInteger('interested_course');
            $table->unsignedInteger('shift')->nullable();
            $table->string('interested_stream')->nullable();
            $table->date('english_final_admission_date')->nullable();
            $table->string('nepali_final_admission_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->unsignedInteger('known_from')->nullable();
            $table->string('known_from_other')->nullable();
            $table->text('books_taken')->nullable();

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_registrations');
    }
}
