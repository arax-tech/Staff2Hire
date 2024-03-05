<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('title');
            $table->string('category');
            $table->string('company_name');
            $table->string('location');
            $table->string('type');
            $table->string('salery');
            $table->string('commission');
            $table->string('minimum_age');
            $table->string('experience');
            $table->string('experience_required');
            $table->string('education');
            $table->string('description');
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
        Schema::dropIfExists('jobs');
    }
}
