<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTaskCityRequest;
use App\Http\Requests\StoreTaskCityRequest;
use App\Http\Requests\UpdateTaskCityRequest;
use App\TaskCity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TaskCityController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('task_city_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TaskCity::query()->select(sprintf('%s.*', (new TaskCity)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'task_city_show';
                $editGate      = 'task_city_edit';
                $deleteGate    = 'task_city_delete';
                $crudRoutePart = 'task-cities';

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
            $table->editColumn('city_name', function ($row) {
                return $row->city_name ? $row->city_name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.taskCities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('task_city_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taskCities.create');
    }

    public function store(StoreTaskCityRequest $request)
    {
        $taskCity = TaskCity::create($request->all());

        return redirect()->route('admin.task-cities.index');
    }

    public function edit(TaskCity $taskCity)
    {
        abort_if(Gate::denies('task_city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.taskCities.edit', compact('taskCity'));
    }

    public function update(UpdateTaskCityRequest $request, TaskCity $taskCity)
    {
        $taskCity->update($request->all());

        return redirect()->route('admin.task-cities.index');
    }

    public function show(TaskCity $taskCity)
    {
        abort_if(Gate::denies('task_city_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskCity->load('cityTasks');

        return view('admin.taskCities.show', compact('taskCity'));
    }

    public function destroy(TaskCity $taskCity)
    {
        abort_if(Gate::denies('task_city_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskCity->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaskCityRequest $request)
    {
        TaskCity::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
