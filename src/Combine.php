<?php

namespace Fector\Harvest;

use Fector\Harvest\Instructions\InstructionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Combine
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Builder
     */
    protected $originalBuilder;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Model
     */
    protected $originalModel;

    /**
     * @param Builder $builder
     * @return Combine
     */
    public function setBuilder(Builder $builder): Combine
    {
        $this->builder = $builder;
        $this->originalBuilder = clone $builder;
        return $this;
    }

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * @param Model $model
     * @return Combine
     */
    public function setModel(Model $model): Combine
    {
        $this->model = $model;
        $this->originalModel = clone $model;
        return $this;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param InstructionInterface $instruction
     * @return Combine
     */
    public function recycle(InstructionInterface $instruction): Combine
    {
        $action = $instruction->action();
        $action($this->builder);
        return $this;
    }

    /**
     * @param InstructionInterface $instruction
     * @return Combine
     */
    public function compose(InstructionInterface $instruction): Combine
    {
        $action = $instruction->action();
        $action($this->model);
        return $this;
    }
}