<?php

namespace Fector\Harvest;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Harvester
 * @package Fector\Harvest
 */
class Harvester implements HarvesterInterface
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function recycleModel(Model $model): Model
    {
        return $model;
    }
}
