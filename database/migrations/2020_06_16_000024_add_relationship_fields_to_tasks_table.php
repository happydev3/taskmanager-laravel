<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_1618385')->references('id')->on('task_statuses');
            $table->unsignedInteger('assigned_to_id')->nullable();
            $table->foreign('assigned_to_id', 'assigned_to_fk_1618389')->references('id')->on('users');
            $table->unsignedInteger('applicant_id')->nullable();
            $table->foreign('applicant_id', 'applicant_fk_1624508')->references('id')->on('crm_customers');
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_1624655')->references('id')->on('task_cities');
            $table->unsignedInteger('subdivision_id')->nullable();
            $table->foreign('subdivision_id', 'subdivision_fk_1625772')->references('id')->on('task_subdivisions');
            $table->unsignedInteger('survey_by_id')->nullable();
            $table->foreign('survey_by_id', 'survey_by_fk_1625774')->references('id')->on('users');
            $table->unsignedInteger('dwg_by_id')->nullable();
            $table->foreign('dwg_by_id', 'dwg_by_fk_1625776')->references('id')->on('users');
        });
    }
}
