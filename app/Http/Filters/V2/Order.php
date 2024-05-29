<?php

namespace App\Http\Filters\V2;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Order {
    protected string|null $orderBy = null;
    protected string $orderDir = 'asc';
    public function __construct($orderData) {
        if (is_string($orderData)) {
            $this->buildOrder(explode(' ', $orderData));
        } else {
            $this->buildOrder([]);
        }
    }

    protected function buildOrder($orderData) {
        if (count($orderData) === 2) {
            $this->orderBy = $orderData[0];
            $orderDir = trim(strtolower($orderData[1]));
            $this->orderDir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : $this->orderDir;
        }
    }

    public function applyOrder(BuilderContract $builder) {
        //$columns = $builder->getConnection()->getSchemaBuilder()->getColumnListing($builder->from);
        $columns = $builder->getConnection()->getSchemaBuilder()->getColumnListing($builder->getModel()->getTable());
        if ($this->orderBy && in_array($this->orderBy, $columns)) {
            $builder->orderBy($this->orderBy, $this->orderDir);
        }
        return $builder;
    }
}
