<?php

use PHPUnit\Framework\TestCase;
use Fector\Harvester\Combine;
use Fector\Harvester\Modifier;

class AnyObject
{
    /**
     * @var string
     */
    public $key = '';

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var bool
     */
    public $success = false;

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function orderBy(string $key, string $value)
    {
        $this->success = true;
        $this->key = $key;
        $this->value = $value;
        return $this;
    }
}

class DataModifierTest extends TestCase
{
    /**
     * testing combine
     */
    public function testCombine()
    {
        $combine = new Combine(['_sort' => 'title']);
        $sorter = $this->createMock(Modifier::class);
        $sorter->method('getAction')->willReturn([
            'method' => 'orderBy',
            'args' => ['title', 'asc']
        ]);
        $sorter->method('isValid')->willReturn(true);
        $combine->loadModifier('_sort', $sorter);
        $this->assertEquals(true, $combine->hasModifier('_sort'));
        $this->assertEquals($sorter, $combine->getModifierInstance('_sort'));
        $anyObject = new AnyObject();
        $anyObject = $combine->recycle($anyObject);
        $this->assertEquals(true, $anyObject->success);
    }
}
