<?php

namespace Fector\Harvest\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SelectDecorator
 * @package Fector\Harvest\Decorators
 */
class SelectDecorator extends AbstractDecorator
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        $builder = $this->harvester->recycleBuilder($builder);
        $args = $this->getArgs($this->value);

        if (empty($args)) {
            return $builder;
        }
        return $builder->select($args);
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function recycleModel(Model $model): Model
    {
        $model = $this->harvester->recycleModel($model);
        return $model;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function canUse(string $value): bool
    {
        return (bool)preg_match('/^[a-z][a-z_.]*$/', $value);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function getArgs(string $value): array
    {
        $args = [];
        foreach (explode(',', $value) as $arg) {
            $this->canUse($arg) && ($args[] = $arg);
        }
        return $args;
    }
}
