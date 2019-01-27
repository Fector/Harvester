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
    protected $_param; // @codingStandardsIgnoreLine

    /**
     * @var string
     */
    protected $_relation;

    /**
     * @var string
     */
    protected $_field;

    /**
     * @var string
     */
    protected $_operator;

    /**
     * @var string
     */
    protected $_value; // @codingStandardsIgnoreLine

    /**
     * @var string
     */
    protected $_type; // @codingStandardsIgnoreLine

    /**
     * @var \Closure
     */
    protected $_action; // @codingStandardsIgnoreLine

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
        $body = $arg[$param];
        $this->_param = $param;
        $delimiterPos = strripos($this->param, '.');

        if ($delimiterPos !== false) {
            $this->_relation = substr($this->param, 0, $delimiterPos);
            $this->_field = substr($this->param, $delimiterPos + 1);
        }

        if (!is_array($body)) {
            $this->_type = 'equal';
            $this->_value = $body;
        } elseif (is_array($body)) {
            if (key_exists('in', $body)) {
                $this->_type = 'inArray';
                $this->_value = $body['in'];
            } elseif (key_exists('not_in', $body)) {
                $this->_type = 'notInArray';
                $this->_value = $body['not_in'];
            } elseif (key_exists('is', $body)) {
                $this->_type = 'isNull';
            } elseif (key_exists('is_not', $body)) {
                $this->_type = 'isNotNull';
            }
        } else {
            $this->_type = 'unknown';
        }

        $this->buildAction();
    }

    /**
     * @return void
     */
    protected function buildAction(): void
    {
        switch ($this->_type) {
            case 'equal':
                break;
            case 'inArray':
                $method = 'whereIn';
                break;
            case 'notInArray':
                $method = 'whereNotIn';
                break;
            case 'isNull':
                $method = 'whereNull';
                break;
            case 'isNotNull':
                $method = 'whereNotNull';
                break;
            default:
        }

        if (isset($method)) {
            $methodArgs = [$this->value];
            if (in_array($method, [
                'whereNull',
                'whereNotNull',
            ])) {
                $methodArgs = [];
            }

            if ($this->_relation &&
                $this->_field) {
                $this->_action = (function (Builder $builder) use ($method, $methodArgs) {
                    return $builder->whereHas($this->_relation, function (Builder $query) use ($method, $methodArgs) {
                        array_unshift($methodArgs, $query
                            ->getModel()
                            ->getTable() . '.' . $this->_field);
                        $query->{$method}(...$methodArgs);
                    });
                })->bindTo($this);
            } else {
                $this->_action = (function (Builder $builder) use ($method, $methodArgs) {
                    array_unshift($methodArgs, $this->param);
                    return $builder->{$method}(...$methodArgs);
                })->bindTo($this);
            }
        }
    }
}
