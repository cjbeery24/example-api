<?php

namespace App\Http\Resources\V2;

use App\Http\Filters\V2\Filter;
use App\Http\Filters\V2\QueryFilter;
use App\Http\Filters\V2\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    protected QueryFilter|null $queryFilter = null;
    public function __construct($resource, mixed $queryFilter = null)
    {
        if ($queryFilter instanceof QueryFilter) {
            $this->queryFilter = $queryFilter;
        }
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = parent::toArray($request);
        if ($this->queryFilter) {
            $filter = $this->queryFilter->getFilter();
            return $this->filterFields($items, $filter);
        }
        return $items;
    }

    protected function filterFields($item, Filter $filter = null) {
        $filterData = ApiResourceCollection::parseFilter($filter);
        if ($filterData['fields'] && count($filterData['fields']) && count($filterData['fields']) !== count($filterData['relationFields'])) {
            $usedData = array_intersect_key($item, array_flip($filterData['fields']));
            /* @var Relation $relation */
            foreach ($filterData['relations'] as $relation) {
                if ($relation->scope) {
                    $usedData[$relation->relation] = ApiResourceCollection::filterFields($usedData[$relation->relation], $relation->scope);
                }
            }
            $item = $usedData;
        }

        return $item;
    }
}
