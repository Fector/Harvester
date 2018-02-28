<?php

namespace Fector\Harvest;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentHarvester
 * @package Fector\Harvest
 */
class EloquentHarvester
{
    /**
     * @var array
     */
    protected $queries = [];

    /**
     * @var Combine
     */
    protected $combine;

    /**
     * @var Configuration
     */
    protected $config;


    /**
     * EloquentHarvester constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->queries = $request->query();
        $options = config('harvest');
        //@TODO вынести это гавно
        $this->combine =  new Combine();
        $this->config = new Configuration($options);
    }

    /**
     * @param Builder $builder
     * @return Builder
     *
     * @throws
     */
    public function recycle(Builder $builder): Builder {
        $this->combine->setBuilder($builder);
        foreach ($this->queries as $key => $value) {
            $this->combine->recycle($this->config->getInstruction($key, $value));
        }
        return $this->combine->getBuilder();
    }

    /**
     * @param Model $model
     * @return Model
     *
     * @throws
     */
    public function compose(Model $model): Model
    {
        $this->combine->setModel($model);
        foreach ($this->queries as $key => $value) {
            $this->combine->compose($this->config->getInstruction($key, $value));
        }
        return $this->combine->getModel();
    }
}