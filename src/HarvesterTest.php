<?php

use PHPUnit\Framework\TestCase;
use Fector\Harvest\Harvester;
use Fector\Harvest\Combines\CombineInterface;
use Fector\Harvest\Combines\Limiter;

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

class HarvesterTest extends TestCase
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
        $harvester->loadCombine('_sort', $combine);
        $this->assertEquals(true, $harvester->hasCombine('_sort'));
        $this->assertEquals($combine, $harvester->getCombineInstance('_sort'));

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
        $harvester->loadCombine('_sort', $combine);
        $this->assertEquals(true, $harvester->hasCombine('_sort'));
        $this->assertEquals($combine, $harvester->getCombineInstance('_sort'));

        $anyObject = new AnyObject();
        $anyObject = $harvester->recycle($anyObject);
        $this->assertEquals('title', $anyObject->key);
        $this->assertEquals(20, $anyObject->limit);
    }

    public function testLoadDefaultCombines()
    {
        $sorter = $this->createMock(CombineInterface::class);
        $harvester = new Harvester(
            ['_sort' => 'title'],
            [
                '_sort' => $sorter,
                '_limit' => Limiter::class
            ]
        );
        $this->assertTrue($harvester->hasCombine('_sort'));
        $this->assertTrue($harvester->hasCombine('_limit'));
        $this->assertFalse($harvester->hasCombine('_with'));
    }
}
