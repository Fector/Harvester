<?php

namespace Fector\Harvest;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentHarvester
 * @package Fector\Harvest
 */
class EloquentHarvester
{
    protected $defaultHarvester;

    public function __construct(Request $request)
    {
        $this->defaultHarvester = new Harvester($request->all(), config('harvest.combines'));
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function recycle(Builder $model): Builder
    {
        return $this->defaultHarvester->recycle($model);
    }
}