<?php

namespace Phing\Task\System\Properties\Merge;

use InvalidArgumentException;
use Phing\Task\System\Properties\KeyValueCollection;

/**
 * Interface Factory.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
interface Factory
{
    /**
     * @throws InvalidArgumentException
     */
    public function merge(string $dir, array $files, string $merge_type, string $prompt = null): KeyValueCollection;
}
