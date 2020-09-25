<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTaskSubdivisionRequest;
use App\Http\Requests\StoreTaskSubdivisionRequest;
use App\Http\Requests\UpdateTaskSubdivisionRequest;
use App\TaskSubdivision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TaskSubdivisionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('task_subdivision_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TaskSubdivision::query()->select(sprintf('%s.*', (new TaskSubdivision)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'task_subdivision_show';
                $editGate      = 'task_subdivision_edit';
                $deleteGate    = 'task_subdivision_delete';
                $crudRoutePart = 'task-subdivisions';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('subdivision_name', function ($row) {
                return $row->subdivision_name ? $row->subdivision_name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.taskSubdivisions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('task_subdivision_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taskSubdivisions.create');
    }

    public function store(StoreTaskSubdivisionRequest $request)
    {
        $taskSubdivision = TaskSubdivision::create($request->all());

        return redirect()->route('admin.task-subdivisions.index');
    }

    public function edit(TaskSubdivision $taskSubdivision)
    {
        abort_if(Gate::denies('task_subdivision_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taskSubdivisions.edit', compact('taskSubdivision'));
    }

    public function update(UpdateTaskSubdivisionRequest $request, TaskSubdivision $taskSubdivision)
    {
        $taskSubdivision->update($request->all());

        return redirect()->route('admin.task-subdivisions.index');
    }

    public function show(TaskSubdivision $taskSubdivision)
    {
        abort_if(Gate::denies('task_subdivision_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskSubdivision->load('subdivisionTasks');

        return view('admin.taskSubdivisions.show', compact('taskSubdivision'));
    }

    public function destroy(TaskSubdivision $taskSubdivision)
    {
        abort_if(Gate::denies('task_subdivision_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskSubdivision->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaskSubdivisionRequest $request)
    {
        TaskSubdivision::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
