<?php

namespace Fector\Harvester;

/**
 * Interface Modifier
 * @package Fector\Harvester
 */
interface Modifier
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