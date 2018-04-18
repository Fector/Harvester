<?php

namespace Fector\Harvest;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface HarvesterInterface
 * @package Fector\Harvest
 */
interface HarvesterInterface
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder;

    /**
     * @param Model $model
     * @return Model
     */
    public function recycleModel(Model $model): Model;
}