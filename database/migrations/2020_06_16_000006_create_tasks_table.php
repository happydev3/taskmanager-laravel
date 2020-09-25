<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->date('due_date')->nullable();
            $table->string('lot')->nullable();
            $table->string('block')->nullable();
            $table->string('plan')->nullable();
            $table->string('ascm')->nullable();
            $table->string('job_type')->nullable();
            $table->string('optional_email')->nullable();
            $table->string('houseno_unit')->nullable();
            $table->string('street')->nullable();
            $table->string('contact_person')->nullable();
            $table->boolean('passed')->default(0)->nullable();
            $table->boolean('failed')->default(0)->nullable();
            $table->boolean('resurveyed')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
