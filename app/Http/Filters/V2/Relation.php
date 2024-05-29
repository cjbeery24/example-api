<?php

namespace App\Http\Filters\V2;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Relation {
    public string|null $relation = null;
    public Filter|null $scope = null;
    public function __construct($relationData) {
        if (isset($relationData['relation'])) {
            $this->relation = $relationData['relation'];
        }
        if (isset($relationData['scope'])) {
            $this->scope = new Filter($relationData['scope']);
        }
    }

    public function applyRelation(BuilderContract $builder) {
        $scope = $this->scope;
        $builder->with($this->relation, function ($query) use ($scope) {
            if ($scope) {
                $scope->applyFilter($query);
            }
        });
    }
}
