<?php

namespace App\Http\Filters\V2;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Where {
    protected array $where = [];
    protected array $or = [];
    protected array $and = [];
    public function __construct($whereData) {
        if (is_array($whereData)) {
            $this->buildWhere($whereData);
        } else if (is_string($whereData)) {
            try {
                $this->buildWhere(json_decode($whereData));
            } catch (\Exception $exception) {
                $this->buildWhere([]);
            }
        } else {
            $this->buildWhere([]);
        }
    }

    protected function buildWhere($whereData) {
        foreach ($whereData as $key => $value) {
            if ($key === 'or') {
                foreach($value as $orExpression) {
                    $this->or[] = new Where($orExpression);
                }
            } else if ($key === 'and') {
                foreach($value as $andExpression) {
                    $this->and[] = new Where($andExpression);
                }
            } else {
                $this->where[$key] = new Expression($value);
            }
        }
    }

    public function applyWhere(BuilderContract $builder) {
        foreach($this->where as $key => $expression) {
            $builder->where($key, $expression->operator, $expression->value);
        }
        if (count($this->or)) {
            $or = $this->or;
            $builder->where(function($query) use ($or) {
                foreach ($or as $orWhere) {
                    $query->orWhere(function($orWhereQuery) use ($orWhere) {
                        $orWhere->applyWhere($orWhereQuery);
                    });
                }
            });
        }
        if (count($this->and)) {
            $and = $this->and;
            $builder->where(function($query) use ($and) {
                foreach ($and as $andWhere) {
                    $andWhere->applyWhere($query);
                }
            });
        }
        return $builder;
    }
}
