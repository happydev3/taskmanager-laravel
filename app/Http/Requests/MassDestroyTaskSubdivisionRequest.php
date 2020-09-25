<?php

namespace App\Http\Requests;

use App\TaskSubdivision;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTaskSubdivisionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('task_subdivision_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:task_subdivisions,id',
        ];
    }
}
