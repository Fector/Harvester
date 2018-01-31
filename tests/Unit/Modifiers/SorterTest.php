<?php
use PHPUnit\Framework\TestCase;
use Fector\Harvester\Combines\Sorter;

class SorterTest extends TestCase
{
    /**
     * @return array
     */
    public function actionProvider()
    {
        return [
            ['title', ['title', 'asc']],
            ['-title', ['title', 'desc']]
        ];
    }

    /**
     * @return array
     */
    public function validatorProvider()
    {
        return [
            ['title', true],
            ['first_name', true],
            ['-title', true],
            ['-first_name', true],
            ['342title', false],
            ['№234', false],
        ];
    }

    /**
     * @dataProvider actionProvider
     * @param $queryParam
     * @param $expectedArgs
     */
    public function testGetAction($queryParam, $expectedArgs)
    {
        $sorter = new Sorter();
        $action = $sorter->getActions($queryParam);
        $this->assertEquals('orderBy', $action['method']);
        $this->assertEquals($expectedArgs, $action['args']);
    }

    /**
     * @dataProvider validatorProvider
     * @param $value
     * @param $expectedValidation
     */
    public function testIsValid($value, $expectedValidation)
    {
        $sorter = new Sorter();
        $this->assertEquals($expectedValidation, $sorter->isValid($value));
    }
}
