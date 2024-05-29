<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Filters\V2\QueryFilter;
use App\Http\Requests\Api\V2\StorePlatformRequest;
use App\Http\Requests\Api\V2\UpdatePlatformRequest;
use App\Http\Resources\V2\ApiResource;
use App\Http\Resources\V2\ApiResourceCollection;
use App\Models\Platform;
use App\Traits\ApiResponses;

class PlatformController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(QueryFilter $filter)
    {
        return new ApiResourceCollection(Platform::filter($filter), $filter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlatformRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        return new ApiResource($platform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        //
    }
}
