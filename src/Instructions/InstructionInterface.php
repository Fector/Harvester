<?php

namespace Fector\Harvest\Instructions;

interface InstructionInterface
{
    public function action(): \Closure;
    public function canUse(): bool;
}