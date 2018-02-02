<?php

namespace Fector\Harvest\Combines;

/**
 * Class Collector
 * @package Fector\Harvester\Combines
 */
class Collector implements CombineInterface
{
    CONST METHOD_NAME = 'with';

    /**
     * @param string $value
     * @return array
     */
    public function getActions(string $value): array
    {
        return [
            [
                'method' => self::METHOD_NAME,
                'args' => $this->parseArgs($value)
            ]
        ];
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value): bool
    {
        return (bool)preg_match('/^[a-z][a-z_,]+[a-z]$/', $value);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function parseArgs(string $value): array
    {
        $relations = [$value];
        if (strpos($value, ',')) {
            $relations = explode(',', $value);
        }
        return  $relations;
    }

}