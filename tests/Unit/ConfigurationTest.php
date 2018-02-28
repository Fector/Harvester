<?php

use Fector\Harvest\Configuration;
use PHPUnit\Framework\TestCase;
use Fector\Harvest\Instructions\InstructionInterface;

class MegaInstruction implements InstructionInterface
{
    public function action(): \Closure
    {
        return function () { return 'Hello. I\'m stub';};
    }

    public function canUse(): bool
    {
        return true;
    }
}

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    protected $config;

    protected $options = [
        'instructions' => [
            '_mega' => MegaInstruction::class,
        ],
        'delimiter' => ':',
        'subCommandDelimiter' => '->'
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->config = new Configuration($this->options);
    }

    public function testGetInstruction()
    {
        $megaInstruction = new MegaInstruction();
        $this->assertEquals($megaInstruction, $this->config->getInstruction('_mega', 'none'));
    }

    public function testGetDelimiter()
    {
        $this->assertEquals($this->options['delimiter'], $this->config->getDelimiter());

    }

    public function testGetSubCommandDelimiter()
    {
        $this->assertEquals($this->options['subCommandDelimiter'], $this->config->getSubCommandDelimiter());
    }
}
