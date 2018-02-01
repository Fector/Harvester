<?php

namespace Fector\Harvest;

use Fector\Harvest\Combines\CombineInterface;

/**
 * Class Harvester
 * @package Fector\Harvester
 */
class Harvester
{
    /**
     * @var array
     */
    protected $requestData;

    /**
     * @var array
     */
    protected $combines = [];

    /**
     * Combine constructor.
     * @param array $requestData
     * @param array $config
     */
    public function __construct(array $requestData, array $config = [])
    {
        $this->requestData = $requestData;
        $this->combines = $this->loadCombineFromArray($config);
    }

    /**
     * @param $model
     * @return mixed
     */
    public function recycle($model)
    {
        foreach ($this->requestData as $key => $value){
            if ($this->hasCombine($key)){
                $combine = $this->getCombineInstance($key);
                if ($combine->isValid($value)){
                    $actions = $combine->getActions($value);
                    foreach ($actions as $action){
                        $model = call_user_func_array([$model, $action['method']], $action['args']);
                    }
                }
            }
        }
        return $model;
    }

    /**
     * @param string $key
     * @param CombineInterface $modifier
     */
    public function loadCombine(string $key, CombineInterface $modifier): void
    {
        $this->combines[$key] = $modifier;
    }

    /**
     * @param string $key
     * @return CombineInterface
     */
    public function getCombineInstance(string $key): CombineInterface
    {
        return $this->combines[$key];
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasCombine($key): bool
    {
        return (isset($this->combines[$key]) && $this->combines[$key]);
    }

    /**
     * @param array $config
     * @return array
     */
    protected function loadCombineFromArray(array $config): array
    {
        $combines = [];
        foreach ($config as $key => $value){
            if ($value instanceof CombineInterface){
                $combines[$key] = $value;
                continue;
            }
            $combine = new $value();
            if ($combine instanceof CombineInterface){
                $combines[$key] = $combine;
            }
        }
        return $combines;
    }
}