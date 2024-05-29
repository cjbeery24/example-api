<?php

namespace App\Http\Resources\V2;

use App\Http\Filters\V2\Filter;
use App\Http\Filters\V2\QueryFilter;
use App\Http\Filters\V2\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceCollection extends ResourceCollection
{
    protected QueryFilter|null $queryFilter = null;
    public function __construct($resource, QueryFilter $queryFilter)
    {
        $this->queryFilter = $queryFilter;
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = parent::toArray($request);
        $filter = $this->queryFilter->getFilter();
        return $this->filterFields($items, $filter);
    }

    public static function parseFilter(Filter $filter = null): array {
        $fields = [];
        $relations = [];
        $relationFields = [];
        if ($filter && $fields = $filter->getFields()) {

            if ($include = $filter->getInclude()) {
                $relations = $include->getRelations();
                /* @var Relation $relation */
                foreach ($relations as $relation) {
                    $relationFields[] = $relation->relation;
                }
            }
            $fields = array_merge($fields, $relationFields);
        }
        return [
            'fields' => $fields,
            'relations' => $relations,
            'relationFields' => $relationFields,
        ];
    }

    public static function filterFields($items, Filter $filter = null) {
        $filterData = self::parseFilter($filter);
        if ($filterData['fields'] && count($filterData['fields']) && count($filterData['fields']) !== count($filterData['relationFields'])) {
            $items = array_map(function ($item) use ($filterData) {
                $usedData = array_intersect_key($item, array_flip($filterData['fields']));
                /* @var Relation $relation */
                foreach ($filterData['relations'] as $relation) {
                    if ($relation->scope) {
                        $usedData[$relation->relation] = self::filterFields($usedData[$relation->relation], $relation->scope);
                    }
                }
                return $usedData;
            }, $items);
        }

        return $items;
    }
}
