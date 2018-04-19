<?php

namespace Fector\Harvest\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssociationDecorator
 * @package Fector\Harvest\Decorators
 */
class AssociationDecorator extends AbstractDecorator
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        $builder = $this->harvester->recycleBuilder($builder);
        if ($this->canUse($this->value)) {
            return $builder->with($this->getArg($this->value));
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
        if ($this->canUse($this->value)) {
            return $model->load($this->getArg($this->value));
        }
        return $model;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function canUse(string $value): bool
    {
        return (bool)preg_match('/^[a-z][a-z_.,]+[a-z]$/', $value);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function getArg(string $value): array
    {
        return explode(',', $value);
    }
}