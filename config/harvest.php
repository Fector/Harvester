<?php

return [
    'decorators' => [
        '_sort' => \Fector\Harvest\Decorators\SortDecorator::class,
        '_with' => \Fector\Harvest\Decorators\AssociationDecorator::class,
        '_with_cnt' => \Fector\Harvest\Decorators\CountDecorator::class,
        '_filter' => \Fector\Harvest\Decorators\FilterDecorator::class,
        '_select' => \Fector\Harvest\Decorators\SelectDecorator::class,
    ],
    'delimiter' => ':',
    'subCommandDelimiter' => '->'
];