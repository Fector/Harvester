<?php
use PHPUnit\Framework\TestCase;
use Fector\Harvest\Combines\Limiter;

class LimiterTest extends TestCase
{
    /**
     * @return array
     */
    public function actionProvider()
    {
        return [
            [
                '30',
                [
                    ['method' => 'limit', 'args' => ['30']]
                ]
            ],
            [
                '10:30',
                [
                    ['method' => 'offset', 'args' => ['10']],
                    ['method' => 'limit', 'args' => ['30']]
                ]
            ],
            [
                '10:',
                [
                    ['method' => 'offset', 'args' => ['10']]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function validatorProvider()
    {
        return [
            ['title', false],
            ['-title', false],
            ['20', true],
            ['342title', false],
            ['10:20', true],
        ];
    }

    /**
     * @dataProvider actionProvider
     * @param $queryParam
     * @param $expectedAction
     */
    public function testGetAction($queryParam, $expectedAction)
    {
        $sorter = new Limiter();
        $action = $sorter->getActions($queryParam);
        $this->assertEquals($expectedAction, $action);
    }

    /**
     * @dataProvider validatorProvider
     * @param $value
     * @param $expectedValidation
     */
    public function testIsValid($value, $expectedValidation)
    {
        $sorter = new Limiter();
        $this->assertEquals($expectedValidation, $sorter->isValid($value));
    }
}
