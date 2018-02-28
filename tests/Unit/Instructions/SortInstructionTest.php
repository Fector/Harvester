<?php

use Fector\Harvest\Instructions\SortInstruction;
use PHPUnit\Framework\TestCase;

class SortInstructionTest extends TestCase
{
    public function additionalProvider()
    {
        return [
            'singleAsc' => ['title', [['name' => 'title', 'direction' => 'ASC']]],
            'singleDesc' => ['-title', [['name' => 'title', 'direction' => 'DESC']]],
            'multiple' => ['title,author', [
                ['name' => 'title', 'direction' => 'ASC'], ['name' => 'author', 'direction' => 'ASC']
            ]],
            'multipleWithOppositeDirection' => ['title,-author', [
                ['name' => 'title', 'direction' => 'ASC'], ['name' => 'author', 'direction' => 'DESC']
            ]],
        ];
    }

    /**
     * @dataProvider additionalProvider
     * @param $value
     * @param $expected
     */
    public function testGetArgs($value, $expected)
    {
        $instruction = new SortInstruction($value);
        $this->assertArraySubset($expected, $instruction->args());
    }

    public function testAction()
    {
        $instruction  = new SortInstruction('title');
        $this->assertInstanceOf(\Closure::class, $instruction->action());
    }

    /**
     * @dataProvider additionalProvider
     * @param $value
     */
    public function testCanUse($value)
    {
        $instruction = new SortInstruction($value);
        $this->assertTrue($instruction->canUse());
    }
}
