<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1636545')->references('id')->on('users');
            $table->unsignedInteger('related_task_id');
            $table->foreign('related_task_id', 'related_task_fk_1636546')->references('id')->on('tasks');
        });
    }
}
