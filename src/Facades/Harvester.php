<?php

namespace Fector\Harvest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Harvester
 * @package Fector\Harvest\Facades
 */
class Harvester extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'EloquentHarvester';
    }
}