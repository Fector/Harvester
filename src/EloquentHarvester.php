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
     * EloquentHarvester constructor.
     * @param Request $request
     * @param null $harvester
     */
    public function __construct(Request $request, $harvester = null)
    {
        $this->params = $request->query();
        if (!$harvester) {
            $this->harvester = new Harvester();
        }
        $this->setHarvester($harvester);
        $this->params = config('harvest.decorators');
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
                $harvester = new $decorator($harvester);
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
        return $this->params[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasDecorator(string $key): bool
    {
        return (bool)(isset($this->params['$key']) && $this->params[$key]);
    }
}