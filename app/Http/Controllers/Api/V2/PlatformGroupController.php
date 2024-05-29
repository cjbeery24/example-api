<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Filters\V2\QueryFilter;
use App\Http\Requests\Api\V2\StorePlatformGroupRequest;
use App\Http\Requests\Api\V2\UpdatePlatformGroupRequest;
use App\Http\Resources\V2\ApiResource;
use App\Http\Resources\V2\ApiResourceCollection;
use App\Models\PlatformGroup;
use App\Traits\ApiResponses;

class PlatformGroupController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(QueryFilter $filter)
    {
        return new ApiResourceCollection(PlatformGroup::filter($filter), $filter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlatformGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PlatformGroup $platformGroup, QueryFilter $filter)
    {
        return new ApiResource($platformGroup->filter($filter), $filter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatformGroupRequest $request, PlatformGroup $platformGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatformGroup $platformGroup)
    {
        //
    }
}
