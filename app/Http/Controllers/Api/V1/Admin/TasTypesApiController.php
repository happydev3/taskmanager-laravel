<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTasTypeRequest;
use App\Http\Requests\UpdateTasTypeRequest;
use App\Http\Resources\Admin\TasTypeResource;
use App\TasType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TasTypesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tas_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TasTypeResource(TasType::all());
    }

    public function store(StoreTasTypeRequest $request)
    {
        $tasType = TasType::create($request->all());

        return (new TasTypeResource($tasType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TasType $tasType)
    {
        abort_if(Gate::denies('tas_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TasTypeResource($tasType);
    }

    public function update(UpdateTasTypeRequest $request, TasType $tasType)
    {
        $tasType->update($request->all());

        return (new TasTypeResource($tasType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TasType $tasType)
    {
        abort_if(Gate::denies('tas_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tasType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
