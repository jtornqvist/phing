<?php


namespace Phing\Task\System\Property\Strategy;


interface Strategy
{
    /**
     * The implementing strategy will determine
     * how the properties are filtered using the
     * property prefix string and subsequently
     * returned.
     *
     * @param array $properties
     * @param string $filter
     * @return array
     */
    public function properties(array $properties, string $filter = ''): array;

}
