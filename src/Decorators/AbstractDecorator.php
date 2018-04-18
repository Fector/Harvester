<?php

namespace Fector\Harvest\Decorators;

use Fector\Harvest\HarvesterInterface;

/**
 * Class AbstractDecorator
 * @package Fector\Harvest\Decorators
 */
abstract class AbstractDecorator implements HarvesterInterface
{
    /**
     * @var HarvesterInterface
     */
    protected $harvester;

    /**
     * @var string
     */
    protected $value;

    /**
     * AbstractDecorator constructor.
     * @param HarvesterInterface $harvester
     * @param string $value
     */
    public function __construct(HarvesterInterface $harvester, string $value)
    {
        $this->harvester = $harvester;
        $this->value = $value;
    }
}