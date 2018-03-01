<?php

namespace Fector\Harvest\Instructions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class SortInstruction
 * @package Fector\Harvest\Instructions
 */
class SortInstruction implements InstructionInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * SortInstruction constructor.
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
        $fields = $this->fields;
        return function (Builder $builder) use ($fields) {
            foreach ($fields as $field) {
                $builder->orderBy($field['name'], $field['direction']);
            }
        };
    }

    /**
     * @return bool
     */
    public function canUse(): bool
    {
        return (bool)preg_match('/^\-?[a-z_]+,?-?[a-z_]+$/', $this->value);
    }

    /**
     * @return array
     */
    public function args()
    {
        return $this->fields;
    }

    /**
     * @param string $value
     */
    protected function parse(string $value): void
    {
        $direction = 'ASC';
        $args = explode(',', $value);
        foreach ($args as $arg) {
            if (substr($arg, 0, 1) === '-') {
                $arg = substr($arg, 1);
                $direction = 'DESC';
            }
            array_push($this->fields, ['name' => $arg, 'direction' => $direction]);
        }
    }
}