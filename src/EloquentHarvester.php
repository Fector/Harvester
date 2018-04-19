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
    protected $params = [];

    /**
     * @var HarvesterInterface
     */
    protected $harvester;

    /**
     * @var array
     */
    protected $decorators = [];

    /**
     * EloquentHarvester constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->params = $request->query();
        $this->decorators = config('harvest.decorators');
        $this->harvester = new Harvester();
    }

    /**
     * @param HarvesterInterface $harvester
     */
    public function setHarvester(HarvesterInterface $harvester): void
    {
        $this->harvester = $harvester;
    }

    /**
     * @param Builder|Model $entity
     * @return Builder|Model
     */
    public function recycle($entity)
    {
        $harvester = $this->harvester;
        foreach ($this->params as $key => $value) {
            if ($this->hasDecorator($key) && $decorator = $this->getDecorator($key)) {
                $harvester = new $decorator($harvester, $value);
            }
        }
        if ($entity instanceof Builder) return $harvester->recycleBuilder($entity);
        if ($entity instanceof Model) return $harvester->recycleModel($entity);
        return $entity;
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getDecorator(string $key): string
    {
        return $this->decorators[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasDecorator(string $key): bool
    {
        return (bool)(isset($this->decorators[$key]) && $this->decorators[$key]);
    }
}