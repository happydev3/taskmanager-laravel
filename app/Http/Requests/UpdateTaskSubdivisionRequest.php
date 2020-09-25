<?php

namespace App\Http\Requests;

use App\TaskSubdivision;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskSubdivisionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('task_subdivision_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'subdivision_name' => [
                'required',
            ],
        ];
    }
}
