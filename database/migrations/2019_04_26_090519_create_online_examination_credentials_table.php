<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineExaminationCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_examination_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->nullable();
            $table->string('email')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('registration_number')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('is_client')->default(0);
            $table->string('verification_token')->nullable();
            $table->boolean('verified')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('online_examination_credentials');
    }
}
