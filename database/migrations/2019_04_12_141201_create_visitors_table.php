<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('college_name')->nullable();
            $table->string('marks_obtained')->nullable();
            $table->unsignedInteger('academic_status')->nullable();
            $table->date('english_visited_date')->nullable();
            $table->string('nepali_visited_date')->nullable();
            $table->string('visited_time')->nullable();
            $table->unsignedInteger('counselled_by')->nullable();
            $table->boolean('is_registered')->default(0);
            $table->boolean('is_accompanied')->default(0);
            $table->string('accompanied_by')->nullable();
            $table->unsignedInteger('interested_course')->nullable();
            $table->string('interested_stream')->nullable();
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
        Schema::dropIfExists('visitors');
    }
}
