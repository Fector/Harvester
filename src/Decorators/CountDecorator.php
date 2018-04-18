<?php

namespace Fector\Harvest\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountDecorator
 * @package Fector\Harvest\Decorators
 */
class CountDecorator extends AbstractDecorator
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        $builder = $this->harvester->recycleBuilder($builder);
        if ($this->canUse($this->value)) {
            return $builder->withCount($this->value);
        }
        return $builder;
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
        return (bool)preg_match('/^[a-z][a-z_.]+[a-z]$/', $value);
    }

}