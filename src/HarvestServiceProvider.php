<?php

namespace Fector\Harvest;

use Illuminate\Support\ServiceProvider;

/**
 * Class HarvestServiceProvider
 * @package Fector\Harvest
 */
class HarvestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/harvest.php', 'harvest'
        );
    }

    public function register()
    {
        $this->app->bind('Harvester', 'Fector\Harvest\EloquentHarvester');
    }
}