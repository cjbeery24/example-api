<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Filters\V2\QueryFilter;
use App\Http\Requests\Api\V2\StorePlatformPositionRequest;
use App\Http\Requests\Api\V2\UpdatePlatformPositionRequest;
use App\Http\Resources\V2\ApiResource;
use App\Http\Resources\V2\ApiResourceCollection;
use App\Models\PlatformPosition;

class PlatformPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(QueryFilter $filter)
    {
        return new ApiResourceCollection(PlatformPosition::filter($filter), $filter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlatformPositionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PlatformPosition $platformPosition)
    {
        return new ApiResource($platformPosition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatformPositionRequest $request, PlatformPosition $platformPosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatformPosition $platformPosition)
    {
        //
    }
}
