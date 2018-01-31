<?php

use PHPUnit\Framework\TestCase;
use Fector\Harvester\Combine;
use Fector\Harvester\Modifier;

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
        $combine = new Combine(['_sort' => 'title']);
        $sorter = $this->createMock(Modifier::class);
        $sorter->method('getActions')->willReturn([
            [
                'method' => 'orderBy',
                'args' => ['title', 'asc']
            ]
        ]);
        $sorter->method('isValid')->willReturn(true);
        $combine->loadModifier('_sort', $sorter);
        $this->assertEquals(true, $combine->hasModifier('_sort'));
        $this->assertEquals($sorter, $combine->getModifierInstance('_sort'));

        $anyObject = new AnyObject();
        $anyObject = $combine->recycle($anyObject);
        $this->assertEquals('title', $anyObject->key);
    }

    public function testRecycleWithMultipleMethods()
    {
        $combine = new Combine(['_sort' => 'title']);
        $limiter = $this->createMock(Modifier::class);
        $limiter->method('getActions')->willReturn([
            [
                'method' => 'orderBy',
                'args' => ['title', 'asc']
            ],
            [
                'method' => 'limit',
                'args' => [20]
            ]
        ]);
        $limiter->method('isValid')->willReturn(true);
        $combine->loadModifier('_sort', $limiter);
        $this->assertEquals(true, $combine->hasModifier('_sort'));
        $this->assertEquals($limiter, $combine->getModifierInstance('_sort'));

        $anyObject = new AnyObject();
        $anyObject = $combine->recycle($anyObject);
        $this->assertEquals('title', $anyObject->key);
        $this->assertEquals(20, $anyObject->limit);

    }
}
