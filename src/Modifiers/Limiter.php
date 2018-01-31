<?php

namespace Fector\Harvester\Modifiers;

use Fector\Harvester\Modifier;

/**
 * Class Limiter
 * @package Fector\Harvester\Modifiers
 */
class Limiter implements Modifier
{
    CONST OFFSET_METHOD = 'offset';
    CONST LIMIT_METHOD = 'limit';

    /**
     * @param string $value
     * @return array
     */
    public function getAction(string $value): array
    {
        $args = $this->parseArgs($value);
        $actions = [];
        if ($args[0]){
            $actions[] = ['method' => self::OFFSET_METHOD, 'args' => [$args[0]]];
        }
        if ($args[1]) {
            $actions[] = ['method' => self::LIMIT_METHOD, 'args' => [$args[1]]];
        }
        return $actions;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value): bool
    {
        return (bool)preg_match('/^[0-9]+:?[0-9]+$/', $value);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function parseArgs(string $value): array
    {
        $limit = $value;
        $offset = false;
        if ($pos = strpos($value, ':')){
            list($offset, $limit) = explode(':', $value, 2);
        }
        return  [$offset, $limit];
    }
}