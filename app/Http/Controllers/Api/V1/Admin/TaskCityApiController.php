<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskCityRequest;
use App\Http\Requests\UpdateTaskCityRequest;
use App\Http\Resources\Admin\TaskCityResource;
use App\TaskCity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskCityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('task_city_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskCityResource(TaskCity::all());
    }

    public function store(StoreTaskCityRequest $request)
    {
        $taskCity = TaskCity::create($request->all());

        return (new TaskCityResource($taskCity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TaskCity $taskCity)
    {
        abort_if(Gate::denies('task_city_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskCityResource($taskCity);
    }

    public function update(UpdateTaskCityRequest $request, TaskCity $taskCity)
    {
        $taskCity->update($request->all());

        return (new TaskCityResource($taskCity))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TaskCity $taskCity)
    {
        abort_if(Gate::denies('task_city_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskCity->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
