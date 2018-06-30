<?php

namespace Fector\Harvest\Helpers;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Condition
 * @package Fector\Harvest\Helpers
 *
 * @property $type
 * @property $action
 * @property $param
 * @property $operator
 * @property $value
 */
class Condition
{
    /**
     * @var array
     */
    protected $comparators = [
        '=',
        '>',
        '>=',
        '<',
        '<=',
    ];

    /**
     * @var string
     */
    protected $_param;

    /**
     * @var string
     */
    protected $_operator;

    /**
     * @var string
     */
    protected $_value;

    /**
     * @var string
     */
    protected $_type;

    /**
     * @var \Closure
     */
    protected $_action;

    /**
     * Condition constructor.
     * @param array $arg
     */
    public function __construct(array $arg)
    {
        $this->identify($arg);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $fieldName = '_' . $name;
        return $this->$fieldName;
    }

    /**
     * @param array $arg
     */
    protected function identify(array $arg): void
    {
        $param = key($arg);
        $this->_param = $param;
        $body = $arg[$param];
        $c = $this;
        if (!is_array($body)) {
            $this->_type = 'equal';
            $this->_value = $body;
            if (stripos($this->param, '.')) {
                list($relation, $field) = explode('.', $this->param);
                $this->_action = function (Builder $builder) use ($c, $relation, $field) {
                    return $builder->whereHas($relation, function ($query) use ($field, $c) {
                        $query->where($field, $c->value);
                    });
                };
                return;
            }
            $this->_action = function (Builder $builder) use ($c) {
                return $builder->where($c->param, $c->value);
            };
            return;
        }
        if (is_array($body)) {
            if (key_exists('in', $body)) {
                $this->_type = 'inArray';
                $this->_value = $body['in'];
                if (stripos($this->param, '.')) {
                    list($relation, $field) = explode('.', $this->param);
                    $this->_action = function (Builder $builder) use ($c, $relation, $field) {
                        return $builder->whereHas($relation, function ($query) use ($c, $relation, $field) {
                            $query->whereIn(implode('.', [$relation, $field]), $c->value);
                        });
                    };
                    return;
                }
                $this->_action = function (Builder $builder) use ($c) {
                    return $builder->whereIn($c->param, $c->value);
                };
                return;
            }
            if (key_exists('not_in', $body)) {
                $this->_type = 'notInArray';
                $this->_value = $body['not_in'];
                $this->_action = function (Builder $builder) use ($c) {
                    return $builder->whereNotIn($c->param, $c->value);
                };
                return;
            }
            if (key_exists('is', $body)) {
                $this->_type = 'isNull';
                $this->_action = function (Builder $builder) use ($c) {
                    return $builder->whereNull($c->param);
                };
                return;
            }
            if (key_exists('is_not', $body)) {
                $this->_type = 'isNotNull';
                $this->_action = function (Builder $builder) use ($c) {
                    return $builder->whereNotNull($c->param);
                };
                return;
            }
        }
        $this->_type = 'unknown';
    }
}