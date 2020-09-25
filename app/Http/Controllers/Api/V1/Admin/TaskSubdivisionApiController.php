<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskSubdivisionRequest;
use App\Http\Requests\UpdateTaskSubdivisionRequest;
use App\Http\Resources\Admin\TaskSubdivisionResource;
use App\TaskSubdivision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskSubdivisionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('task_subdivision_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskSubdivisionResource(TaskSubdivision::all());
    }

    public function store(StoreTaskSubdivisionRequest $request)
    {
        $taskSubdivision = TaskSubdivision::create($request->all());

        return (new TaskSubdivisionResource($taskSubdivision))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TaskSubdivision $taskSubdivision)
    {
        abort_if(Gate::denies('task_subdivision_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskSubdivisionResource($taskSubdivision);
    }

    public function update(UpdateTaskSubdivisionRequest $request, TaskSubdivision $taskSubdivision)
    {
        $taskSubdivision->update($request->all());

        return (new TaskSubdivisionResource($taskSubdivision))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TaskSubdivision $taskSubdivision)
    {
        abort_if(Gate::denies('task_subdivision_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskSubdivision->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
