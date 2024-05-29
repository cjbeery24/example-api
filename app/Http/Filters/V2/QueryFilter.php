<?php

namespace App\Http\Filters\V2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter {
    const MAX_PER_PAGE = 1000;
    protected Request $request;
    protected Builder $builder;
    protected int $perPage = 250;
    protected int $page = 1;
    protected Filter|null $filter = null;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function getPerPage(): int {
        return min($this->perPage, self::MAX_PER_PAGE);
    }

    public function getPage(): int {
        return $this->page;
    }

    public function getFilter(): Filter|null {
        return $this->filter;
    }

    public function apply(Builder $builder): Builder {
        $this->builder = $builder;

        $filterData = $this->request->input('filter');
        if ($filterData) {
            $this->filter = $this->applyFilters($filterData);
        }

        return $builder;
    }

    protected function applyFilters($filterData): Filter {
        if (is_array($filterData)) {
            $filter = new Filter($filterData);
        } else if (is_string($filterData)) {
            try {
                $filterData = json_decode($filterData);
                $filter = new Filter($filterData);
            } catch (\Exception $exception) {
                $filter = new Filter([]);
            }
        } else {
            $filter = new Filter([]);
        }
        if (isset($filterData['perPage'])) {
            $perPage = (int) $filterData['perPage'];
            $this->perPage = $perPage > 0 ? $perPage : $this->perPage;
        }
        if (isset($filterData['page'])) {
            $page = (int) $filterData['page'];
            $this->page = $page > 0 ? $page : $this->page;
        }
        $filter->applyFilter($this->builder);

        return $filter;
    }
}
