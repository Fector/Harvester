<?php

namespace Fector\Harvest;


use Fector\Harvest\Instructions\InstructionInterface;

class Configuration
{
    /**
     * @var array
     */
    protected $instructions;

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var string
     */
    protected $subCommandDelimiter;

    /**
     * Configuration constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->instructions = $options['instructions'] ?? [];
        $this->delimiter = $options['delimiter'] ?? ':';
        $this->subCommandDelimiter = $options['subCommandDelimiter'] ?? '->';
    }

    /**
     * @param string $key
     * @param string $value
     * @return InstructionInterface
     *
     * @throws
     */
    public function getInstruction(string $key, string $value): InstructionInterface
    {
        if (!isset($this->instructions[$key]) || empty($this->instructions[$key])) {
            throw new \Exception('Not found instruction');
        }
        $instruction  = new $this->instructions[$key]($value);
        return $instruction;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @return string
     */
    public function getSubCommandDelimiter(): string
    {
        return $this->subCommandDelimiter;
    }

}