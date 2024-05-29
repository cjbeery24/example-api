<?php

namespace App\Http\Filters\V2;

class Expression {
    public string $operator;
    public $value;
    public function __construct($value) {
        $this->buildExpression($value);
    }

    protected function buildExpression($value) {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                switch ($key) {
                    case 'gt':
                        $this->operator = '>';
                        break;
                    case 'gte':
                        $this->operator = '>=';
                        break;
                    case 'lt':
                        $this->operator = '<';
                        break;
                    case 'lte':
                        $this->operator = '<=';
                        break;
                    case 'neq':
                        $this->operator = '!=';
                        break;
                    case 'inq':
                        $this->operator = 'IN';
                        if (is_array($value)) {
                            $this->value = $value;
                        } else {
                            $this->value = explode(',', $value);
                        }
                        break;
                }
                if (!$this->value) {
                    $this->value = $value;
                }
                break;
            }
        } else  {
            $this->operator = '=';
            $this->value = $value;
        }
    }
}
