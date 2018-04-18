<?php

return [
    'instructions' => [
        '_sort' => \Fector\Harvest\Instructions\SortInstruction::class,
        '_with' => \Fector\Harvest\Instructions\CollectInstruction::class,
        '_select' => \Fector\Harvest\Instructions\SelectInstruction::class,
        '_filter' => \Fector\Harvest\Instructions\FilterInstruction::class,
        '_limit' => \Fector\Harvest\Instructions\LimitInstruction::class,
    ],
    'delimiter' => ':',
    'subCommandDelimiter' => '->'
];