<?php

namespace App\Http\Requests;

use App\TasType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateTasTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tas_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [];
    }
}
