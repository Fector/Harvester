<?php

use Fector\Harvest\EloquentHarvester;
use PHPUnit\Framework\TestCase;

class EloquentHarvesterTest extends TestCase
{
    public function additionProvider()
    {
        return [
            'orderASC' => [[]],
//            'orderDESC' => [],
//            'orderMultipleASC' => [],
//            'orderMultipleDESC' => [],
//            'orderByNestedRelationField' => [],
//            'orderByFieldInNestedRelation' => [],
//            'withRelation' => [],
//            'withRelations' => [],
//            'loadRelation' => [],
//            'withCountRelation' => [],
//            'nestedRelationLimit' => [],
        ];
    }

    public function testRecycle()
    {
        $this->assertTrue(true);
    }
}
