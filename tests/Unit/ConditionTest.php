<?php

use PHPUnit\Framework\TestCase;
use Fector\Harvest\Helpers\Condition;

class ConditionTest extends TestCase
{
    /**
     * Test the equal condition with string value
     */
    public function testEqualWithString()
    {
        $arg = [
            'status' => 'active',
        ];
        $condition = new Condition($arg);
        $this->assertEquals('equal', $condition->type);
        $this->assertEquals('status', $condition->param);
        $this->assertEquals('active', $condition->value);
    }

    /**
     * Test the equal condition with number value
     */
    public function testEqualWithNum()
    {
        $arg = ['status' => 1];
        $condition = new Condition($arg);
        $this->assertEquals('equal', $condition->type);
        $this->assertEquals('status', $condition->param);
        $this->assertEquals(1, $condition->value);
    }

    public function testInArray()
    {
        $arg = [
            'status' => ['in' => [1,2,'test']]
        ];
        $condition = new Condition($arg);
        $this->assertEquals('inArray', $condition->type);
        $this->assertEquals('status', $condition->param);
        $this->assertEquals([1,2,'test'], $condition->value);
    }

    public function testNotInArray()
    {
        $arg = [
            'status' => ['not_in' => [1,2,'test']]
        ];
        $condition = new Condition($arg);
        $this->assertEquals('notInArray', $condition->type);
        $this->assertEquals('status', $condition->param);
        $this->assertEquals([1,2,'test'], $condition->value);
    }
}
