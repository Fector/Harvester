<?php

namespace Fector\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Harvester
 * @package Fector\Facades
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