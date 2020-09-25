<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubdivisionsTable extends Migration
{
    public function up()
    {
        Schema::create('task_subdivisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subdivision_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
