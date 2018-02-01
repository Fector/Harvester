<?php

namespace Fector\Harvest\Combines;

/**
 * Interface Combine
 * @package Fector\Harvester\Combines
 */
interface CombineInterface
{
    /**
     * @param string $value
     * @return array
     */
    public function getActions(string $value): array;

    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value): bool;
}