<?php

namespace Fector\Harvest;

use Illuminate\Support\ServiceProvider;

/**
 * Class HarvestServiceProvider
 * @package Fector\Harvest
 */
class HarvestServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/harvest.php' => config_path('harvest.php'),
        ]);
        /*$this->mergeConfigFrom(
            __DIR__ . '/../config/harvest.php', 'harvest'
        );*/
    }

    /**
     *
     */
    public function register()
    {
        $this->app->bind('Fector\Harvest\HarvesterInterface', 'Fector\Harvest\Harvester');
        $this->app->bind('Harvester', 'Fector\Harvest\EloquentHarvester');
    }
}
