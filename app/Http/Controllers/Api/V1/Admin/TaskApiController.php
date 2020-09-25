<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Admin\TaskResource;
use App\Task;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskResource(Task::with(['status', 'applicant', 'city', 'subdivision', 'tags', 'survey_by', 'assigned_to', 'dwg_by'])->get());
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->all());
        $task->tags()->sync($request->input('tags', []));

        if ($request->input('client_file', false)) {
            $task->addMedia(storage_path('tmp/uploads/' . $request->input('client_file')))->toMediaCollection('client_file');
        }

        if ($request->input('field_file', false)) {
            $task->addMedia(storage_path('tmp/uploads/' . $request->input('field_file')))->toMediaCollection('field_file');
        }

        if ($request->input('dwg_file', false)) {
            $task->addMedia(storage_path('tmp/uploads/' . $request->input('dwg_file')))->toMediaCollection('dwg_file');
        }

        if ($request->input('final_file', false)) {
            $task->addMedia(storage_path('tmp/uploads/' . $request->input('final_file')))->toMediaCollection('final_file');
        }

        if ($request->input('authority_file', false)) {
            $task->addMedia(storage_path('tmp/uploads/' . $request->input('authority_file')))->toMediaCollection('authority_file');
        }

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        abort_if(Gate::denies('task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaskResource($task->load(['status', 'applicant', 'city', 'subdivision', 'tags', 'survey_by', 'assigned_to', 'dwg_by']));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());
        $task->tags()->sync($request->input('tags', []));

        if ($request->input('client_file', false)) {
            if (!$task->client_file || $request->input('client_file') !== $task->client_file->file_name) {
                $task->addMedia(storage_path('tmp/uploads/' . $request->input('client_file')))->toMediaCollection('client_file');
            }
        } elseif ($task->client_file) {
            $task->client_file->delete();
        }

        if ($request->input('field_file', false)) {
            if (!$task->field_file || $request->input('field_file') !== $task->field_file->file_name) {
                $task->addMedia(storage_path('tmp/uploads/' . $request->input('field_file')))->toMediaCollection('field_file');
            }
        } elseif ($task->field_file) {
            $task->field_file->delete();
        }

        if ($request->input('dwg_file', false)) {
            if (!$task->dwg_file || $request->input('dwg_file') !== $task->dwg_file->file_name) {
                $task->addMedia(storage_path('tmp/uploads/' . $request->input('dwg_file')))->toMediaCollection('dwg_file');
            }
        } elseif ($task->dwg_file) {
            $task->dwg_file->delete();
        }

        if ($request->input('final_file', false)) {
            if (!$task->final_file || $request->input('final_file') !== $task->final_file->file_name) {
                $task->addMedia(storage_path('tmp/uploads/' . $request->input('final_file')))->toMediaCollection('final_file');
            }
        } elseif ($task->final_file) {
            $task->final_file->delete();
        }

        if ($request->input('authority_file', false)) {
            if (!$task->authority_file || $request->input('authority_file') !== $task->authority_file->file_name) {
                $task->addMedia(storage_path('tmp/uploads/' . $request->input('authority_file')))->toMediaCollection('authority_file');
            }
        } elseif ($task->authority_file) {
            $task->authority_file->delete();
        }

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Task $task)
    {
        abort_if(Gate::denies('task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
