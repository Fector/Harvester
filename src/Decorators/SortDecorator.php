<?php

namespace Fector\Harvest\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SortDecorator
 * @package Fector\Harvest\Decorators
 */
class SortDecorator extends AbstractDecorator
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function recycleBuilder(Builder $builder): Builder
    {
        $builder = $this->harvester->recycleBuilder($builder);
        $args = $this->getArgs($this->value);
        foreach ($args as $arg) {
            if ($this->canUse($arg)) {
                $options = $this->getSortOptions($arg);
                $builder->orderBy($options['fieldName'], $options['direction']);
            }
        }
        return $builder;
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function recycleModel(Model $model): Model
    {
        $model = $this->harvester->recycleModel($model);
        return $model;
    }

    /**
     * @param string $arg
     * @return bool
     */
    protected function canUse(string $arg): bool
    {
        return (bool)preg_match('/^\-?[a-z_]+$/', $arg);
    }

    /**
     * @param string $value
     * @return array
     */
    protected function getSortOptions(string $value): array
    {
        $direction = 'ASC';
        if (substr($value, 0, 1) === '-') {
            $value = substr($value, 1);
            $direction = 'DESC';
        }
        return [
            'fieldName' => $value,
            'direction' => $direction
        ];
    }

    /**
     * @param string $value
     * @return array
     */
    protected function getArgs(string $value): array
    {
        return explode(',', $value);
    }

}