<?php


namespace Phing\Task\System\Properties\Merge;


use InvalidArgumentException;
use Phing\Task\System\Properties\KeyValueCollection;

interface Factory
{

    /**
     * @param string $dir
     * @param array $files
     * @param string $merge_type
     * @param string|null $prompt
     * @return KeyValueCollection
     * @throws InvalidArgumentException
     */
    public function merge(string $dir, array $files, string $merge_type, string $prompt = null): KeyValueCollection;

}
