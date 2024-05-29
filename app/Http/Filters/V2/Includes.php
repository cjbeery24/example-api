<?php

namespace App\Http\Filters\V2;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Includes {
    protected array $relations = [];
    public function __construct($includeData) {
        $this->buildRelation($includeData);
    }

    protected function buildRelation($includeData) {
        if (is_string($includeData)) {
            $this->relations[] = new Relation([
                'relation' => $includeData
            ]);
        } else if (is_array($includeData)) {
            if (isset($includeData['relation'])) {
                $this->relations[] = new Relation(($includeData));
            } else {
                foreach($includeData as $includeDatum) {
                    if (is_string($includeDatum)) {
                        $this->relations[] = new Relation([
                            'relation' => $includeDatum
                        ]);
                    } else {
                        $this->buildRelation($includeDatum);
                    }
                }
            }
        }
    }

    public function applyInclude(BuilderContract $builder) {
        /* @var $relation Relation */
        foreach($this->relations as $relation) {
            $relation->applyRelation($builder);
        }

        return $builder;
    }

    public function getRelations() {
        return $this->relations;
    }
}
