<?php

namespace Fector\Harvest\Decorators;

use Fector\Harvest\Helpers\Condition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FilterDecorator
 * @package Fector\Harvest\Decorators
 */
class FilterDecorator extends AbstractDecorator
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        $builder = $this->harvester->recycleBuilder($builder);
        $args = $this->getArgs($this->value);
        foreach ($args as $arg) {
            $condition = $this->getCondition($arg);
            $action = $condition->action;
            $builder->$action($builder);
        }
        return $builder;
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function recycleModel(Model $model): Model
    {
        return $this->harvester->recycleModel($model);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function getArgs(string $value): array
    {
        $args = json_decode($value, true);
        return $args ? $args : [];
    }

    /**
     * @param array $arg
     * @return Condition
     */
    protected function getCondition(array $arg): Condition
    {
        return new Condition($arg);
    }
}