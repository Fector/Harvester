<?php

namespace Fector\Harvest;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentHarvester
 * @package Fector\Harvest
 */
class EloquentHarvester extends Harvester
{
    /**
     * @param $model
     * @return Model
     */
    public function recycle($model): Model
    {
        return $this->recycleModel($model);
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function recycleModel(Model $model): Model
    {
        return parent::recycle($model);
    }
}