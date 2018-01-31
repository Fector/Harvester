<?php

use PHPUnit\Framework\TestCase;
use Fector\Harvester\Harvester;
use Fector\Harvester\Combines\CombineInterface;

class AnyObject
{
    public $key = '';

    public $value = '';

    public $limit = 100;

    public function orderBy(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
        return $this;
    }

    public function limit($number)
    {
        $this->limit = $number;
        return $this;
    }
}

class CombineTest extends TestCase
{
    public function testRecycleWithSingleMethod()
    {
        $harvester = new Harvester(['_sort' => 'title']);
        $combine = $this->createMock(CombineInterface::class);
        $combine->method('getActions')->willReturn([
            [
                'method' => 'orderBy',
                'args' => ['title', 'asc']
            ]
        ]);
        $combine->method('isValid')->willReturn(true);
        $harvester->loadModifier('_sort', $combine);
        $this->assertEquals(true, $harvester->hasModifier('_sort'));
        $this->assertEquals($combine, $harvester->getModifierInstance('_sort'));

        $anyObject = new AnyObject();
        $anyObject = $harvester->recycle($anyObject);
        $this->assertEquals('title', $anyObject->key);
    }

    public function testRecycleWithMultipleMethods()
    {
        $harvester = new Harvester(['_sort' => 'title']);
        $combine = $this->createMock(CombineInterface::class);
        $combine->method('getActions')->willReturn([
            [
                'method' => 'orderBy',
                'args' => ['title', 'asc']
            ],
            [
                'method' => 'limit',
                'args' => [20]
            ]
        ]);
        $combine->method('isValid')->willReturn(true);
        $harvester->loadModifier('_sort', $combine);
        $this->assertEquals(true, $harvester->hasModifier('_sort'));
        $this->assertEquals($combine, $harvester->getModifierInstance('_sort'));

        $anyObject = new AnyObject();
        $anyObject = $harvester->recycle($anyObject);
        $this->assertEquals('title', $anyObject->key);
        $this->assertEquals(20, $anyObject->limit);

    }
}
