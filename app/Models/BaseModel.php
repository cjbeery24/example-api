<?php

namespace App\Models;

use App\Http\Filters\V2\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model {
    public function scopeFilter(Builder $builder, QueryFilter $filter) {
        $filter->apply($builder);
        if ($builder->getModel()->exists) {
            $model = $builder->getModel();
            return $model->load($builder->getEagerLoads())->toArray();
        } else {
            return $builder->paginate($filter->getPerPage(), ['*'], 'page', $filter->getPage());
        }
    }
}
