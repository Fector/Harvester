<?php

namespace Fector\Harvest\Instructions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class CollectInstruction
 * @package Fector\Harvest\Instructions
 */
class CollectInstruction implements InstructionInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $relations = [];

    /**
     * CollectInstruction constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
        $this->parse($value);
    }

    /**
     * @return \Closure
     */
    public function action(): \Closure
    {
        $relations = $this->relations;
        return function (Builder $builder) use ($relations) {
            $builder->with($relations);
        };
    }

    /**
     * @return bool
     */
    public function canUse(): bool
    {
        return (bool)preg_match('/^[a-z][a-z_,.]+[a-z]$/', $this->value);
    }

    public function args(): array
    {
        return $this->relations;
    }

    protected function parse(string $value): void
    {
        $args = explode(',', $value);
        foreach ($args as $arg) {
            array_push($this->relations, $arg);
        }


    }

}