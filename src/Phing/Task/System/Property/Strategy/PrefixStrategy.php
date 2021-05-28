<?php

namespace Phing\Task\System\Property\Strategy;

use ArrayIterator;
use RegexIterator;

class PrefixStrategy implements Strategy
{
    public function properties(array $properties, string $filter = ''): array
    {
        if ('' === $filter or is_null($filter)) {
            return $properties;
        }

        $a = new ArrayIterator($properties);
        $i = new RegexIterator(
            $a,
            '~^'.preg_quote($filter, '~').'.*~',
            RegexIterator::MATCH,
            RegexIterator::USE_KEY
        );

        return iterator_to_array($i);
    }
}
