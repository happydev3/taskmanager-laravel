<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTasTypeRequest;
use App\Http\Requests\StoreTasTypeRequest;
use App\Http\Requests\UpdateTasTypeRequest;
use App\TasType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TasTypesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('tas_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TasType::query()->select(sprintf('%s.*', (new TasType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'tas_type_show';
                $editGate      = 'tas_type_edit';
                $deleteGate    = 'tas_type_delete';
                $crudRoutePart = 'tas-types';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.tasTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tas_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tasTypes.create');
    }

    public function store(StoreTasTypeRequest $request)
    {
        $tasType = TasType::create($request->all());

        return redirect()->route('admin.tas-types.index');
    }

    public function edit(TasType $tasType)
    {
        abort_if(Gate::denies('tas_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tasTypes.edit', compact('tasType'));
    }

    public function update(UpdateTasTypeRequest $request, TasType $tasType)
    {
        $tasType->update($request->all());

        return redirect()->route('admin.tas-types.index');
    }

    public function show(TasType $tasType)
    {
        abort_if(Gate::denies('tas_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tasTypes.show', compact('tasType'));
    }

    public function destroy(TasType $tasType)
    {
        abort_if(Gate::denies('tas_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tasType->delete();

        return back();
    }

    public function massDestroy(MassDestroyTasTypeRequest $request)
    {
        TasType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
