<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('task_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
