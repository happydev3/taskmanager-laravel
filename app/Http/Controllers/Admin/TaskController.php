<?php

namespace App\Http\Controllers\Admin;

use App\CrmCustomer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task;
use App\TaskCity;
use App\TaskStatus;
use App\TaskSubdivision;
use App\TaskTag;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Task::with(['status', 'applicant', 'city', 'subdivision', 'tags', 'survey_by', 'assigned_to', 'dwg_by'])->select(sprintf('%s.*', (new Task)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'task_show';
                $editGate      = 'task_edit';
                $deleteGate    = 'task_delete';
                $crudRoutePart = 'tasks';

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
            $table->editColumn('job_type', function ($row) {
                return $row->job_type ? Task::JOB_TYPE_RADIO[$row->job_type] : '';
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->addColumn('applicant_first_name', function ($row) {
                return $row->applicant ? $row->applicant->first_name : '';
            });

            $table->editColumn('contact_person', function ($row) {
                return $row->contact_person ? $row->contact_person : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('lot', function ($row) {
                return $row->lot ? $row->lot : "";
            });
            $table->editColumn('block', function ($row) {
                return $row->block ? $row->block : "";
            });
            $table->editColumn('plan', function ($row) {
                return $row->plan ? $row->plan : "";
            });
            $table->editColumn('houseno_unit', function ($row) {
                return $row->houseno_unit ? $row->houseno_unit : "";
            });
            $table->editColumn('street', function ($row) {
                return $row->street ? $row->street : "";
            });
            $table->addColumn('city_city_name', function ($row) {
                return $row->city ? $row->city->city_name : '';
            });

            $table->addColumn('subdivision_subdivision_name', function ($row) {
                return $row->subdivision ? $row->subdivision->subdivision_name : '';
            });

            $table->editColumn('ascm', function ($row) {
                return $row->ascm ? $row->ascm : "";
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];

                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('survey_by_name', function ($row) {
                return $row->survey_by ? $row->survey_by->name : '';
            });

            $table->addColumn('assigned_to_name', function ($row) {
                return $row->assigned_to ? $row->assigned_to->name : '';
            });

            $table->addColumn('dwg_by_name', function ($row) {
                return $row->dwg_by ? $row->dwg_by->name : '';
            });

            $table->editColumn('passed', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->passed ? 'checked' : null) . '>';
            });
            $table->editColumn('failed', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->failed ? 'checked' : null) . '>';
            });
            $table->editColumn('resurveyed', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->resurveyed ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'applicant', 'city', 'subdivision', 'tag', 'survey_by', 'assigned_to', 'dwg_by', 'passed', 'failed', 'resurveyed']);

            return $table->make(true);
        }

        return view('admin.tasks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = TaskStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $applicants = CrmCustomer::all()->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = TaskCity::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subdivisions = TaskSubdivision::all()->pluck('subdivision_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = TaskTag::all()->pluck('name', 'id');

        $survey_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dwg_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tasks.create', compact('statuses', 'applicants', 'cities', 'subdivisions', 'tags', 'survey_bies', 'assigned_tos', 'dwg_bies'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->all());
        $task->tags()->sync($request->input('tags', []));

        foreach ($request->input('client_file', []) as $file) {
            $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('client_file');
        }

        foreach ($request->input('field_file', []) as $file) {
            $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('field_file');
        }

        foreach ($request->input('dwg_file', []) as $file) {
            $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('dwg_file');
        }

        foreach ($request->input('final_file', []) as $file) {
            $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('final_file');
        }

        foreach ($request->input('authority_file', []) as $file) {
            $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('authority_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $task->id]);
        }

        return redirect()->route('admin.tasks.index');
    }

    public function edit(Task $task)
    {
        abort_if(Gate::denies('task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = TaskStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $applicants = CrmCustomer::all()->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = TaskCity::all()->pluck('city_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subdivisions = TaskSubdivision::all()->pluck('subdivision_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = TaskTag::all()->pluck('name', 'id');

        $survey_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dwg_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $task->load('status', 'applicant', 'city', 'subdivision', 'tags', 'survey_by', 'assigned_to', 'dwg_by');

        return view('admin.tasks.edit', compact('statuses', 'applicants', 'cities', 'subdivisions', 'tags', 'survey_bies', 'assigned_tos', 'dwg_bies', 'task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());
        $task->tags()->sync($request->input('tags', []));

        if (count($task->client_file) > 0) {
            foreach ($task->client_file as $media) {
                if (!in_array($media->file_name, $request->input('client_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $task->client_file->pluck('file_name')->toArray();

        foreach ($request->input('client_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('client_file');
            }
        }

        if (count($task->field_file) > 0) {
            foreach ($task->field_file as $media) {
                if (!in_array($media->file_name, $request->input('field_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $task->field_file->pluck('file_name')->toArray();

        foreach ($request->input('field_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('field_file');
            }
        }

        if (count($task->dwg_file) > 0) {
            foreach ($task->dwg_file as $media) {
                if (!in_array($media->file_name, $request->input('dwg_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $task->dwg_file->pluck('file_name')->toArray();

        foreach ($request->input('dwg_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('dwg_file');
            }
        }

        if (count($task->final_file) > 0) {
            foreach ($task->final_file as $media) {
                if (!in_array($media->file_name, $request->input('final_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $task->final_file->pluck('file_name')->toArray();

        foreach ($request->input('final_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('final_file');
            }
        }

        if (count($task->authority_file) > 0) {
            foreach ($task->authority_file as $media) {
                if (!in_array($media->file_name, $request->input('authority_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $task->authority_file->pluck('file_name')->toArray();

        foreach ($request->input('authority_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $task->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('authority_file');
            }
        }

        return redirect()->route('admin.tasks.index');
    }

    public function show(Task $task)
    {
        abort_if(Gate::denies('task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->load('status', 'applicant', 'city', 'subdivision', 'tags', 'survey_by', 'assigned_to', 'dwg_by', 'relatedTaskComments');

        return view('admin.tasks.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        abort_if(Gate::denies('task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaskRequest $request)
    {
        Task::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('task_create') && Gate::denies('task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Task();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
