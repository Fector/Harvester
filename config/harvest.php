<?php

return [
    'instructions' => [
        '_sort' => \Fector\Harvest\Instructions\SortInstruction::class,
        '_with' => \Fector\Harvest\Instructions\CollectInstruction::class,
        /*'_select' => '',
        '_filter' => '',
        '_limit' => '',*/
    ],
    'delimiter' => ':',
    'subCommandDelimiter' => '->'
];