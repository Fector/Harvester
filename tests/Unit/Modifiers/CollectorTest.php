<?php
use PHPUnit\Framework\TestCase;
use Fector\Harvester\Modifiers\Collector;

class CollectorTest extends TestCase
{
    /**
     * @return array
     */
    public function actionProvider()
    {
        return [
            ['books', ['books']],
            ['books_authors', ['books_authors']],
            ['books,authors,posts', ['books', 'authors', 'posts']],
        ];
    }

    /**
     * @return array
     */
    public function validatorProvider()
    {
        return [
            ['books', true],
            ['books_authors', true],
            ['books,authors', true],
            ['books,authors,posts', true],
            ['-first', false],
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
        $collector = new Collector();
        $action = $collector->getAction($queryParam);
        $this->assertEquals('with', $action['method']);
        $this->assertEquals($expectedArgs, $action['args']);
    }

    /**
     * @dataProvider validatorProvider
     * @param $value
     * @param $expectedValidation
     */
    public function testIsValid($value, $expectedValidation)
    {
        $collector = new Collector();
        $this->assertEquals($expectedValidation, $collector->isValid($value));
    }
}
