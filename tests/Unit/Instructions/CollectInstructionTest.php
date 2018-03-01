<?php

use Fector\Harvest\Instructions\CollectInstruction;
use PHPUnit\Framework\TestCase;

class CollectInstructionTest extends TestCase
{
    /**
     * @return array
     */
    public function additionalProvider()
    {
        return [
            'singleRelation' => ['subscribers', ['subscribers']],
            'multipleRelation' => ['author,subscribers', ['author','subscribers']],
            'nestedRelation' => ['author.profile,subscribers', ['author.profile','subscribers']],
        ];
    }

    /**
     *
     */
    public function testAction()
    {
        $instruction  = new CollectInstruction('subscribers');
        $this->assertInstanceOf(\Closure::class, $instruction->action());
    }

    /**
     * @dataProvider additionalProvider
     * @param $value
     */
    public function testCanUse($value)
    {
        $instruction = new CollectInstruction($value);
        $this->assertTrue($instruction->canUse());
    }

    /**
     * @dataProvider additionalProvider
     * @param $value
     * @param $expected
     */
    public function testArgs($value, $expected)
    {
        $instruction = new CollectInstruction($value);
        $this->assertArraySubset($expected, $instruction->args());
    }
}
