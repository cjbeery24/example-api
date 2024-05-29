<?php

namespace App\Http\Filters\V2;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Filter {
    protected array $filterData;

    protected Where|null $where = null;

    protected Order|null $order = null;

    protected int|null $limit = null;

    protected int|null $skip = null;

    protected Includes|null $include = null;

    protected array|null $fields = null;

    public function __construct(array $filterData) {
        $this->filterData = $filterData;
        if (isset($filterData['where'])) {
            $this->buildWhere($filterData['where']);
        }
        if (isset($filterData['order'])) {
            $this->buildOrder($filterData['order']);
        }
        if (isset($filterData['limit'])) {
            $this->buildLimit($filterData['limit']);
        }
        if (isset($filterData['skip'])) {
            $this->buildSkip($filterData['skip']);
        }
        if (isset($filterData['include'])) {
            $this->buildInclude($filterData['include']);
        }
        if (isset($filterData['fields'])) {
            $this->buildFields($filterData['fields']);
        }
    }

    protected function buildWhere($whereData): void {
        $this->where = new Where($whereData);
    }
    protected function buildOrder($orderData): void {
        $this->order = new Order($orderData);
    }
    protected function buildLimit($limitData): void {
        $this->limit = (int) $limitData;
    }
    protected function buildSkip($skipData): void {
        $this->skip = (int) $skipData;
    }
    protected function buildInclude($includeData): void {
        $this->include = new Includes($includeData);
    }
    protected function buildFields($fieldsData): void {
        $this->fields = is_string($fieldsData) ? [$fieldsData] : (is_array($fieldsData) ? $fieldsData : null);
    }

    public function applyFilter(BuilderContract $builder): BuilderContract {
        if ($this->where) {
            $builder = $this->where->applyWhere($builder);
        }
        if ($this->order) {
            $builder = $this->order->applyOrder($builder);
        }
        if ($this->include) {
            $builder = $this->include->applyInclude($builder);
        }
        if ($this->limit) {
            $builder->limit($this->limit);
        }
        if ($this->skip) {
            $builder->skip($this->skip);
        }
        return $builder;
    }

    public function getInclude(): Includes|null {
        return $this->include;
    }
    public function getFields(): array|null {
        return $this->fields;
    }
}
