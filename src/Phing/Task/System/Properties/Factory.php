<?php

namespace Phing\Task\System\Properties;

use Phing\Io\File;

interface Factory
{

    public function read($dir, $filename, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection;

    public function read_file(File $properties_file, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection;

    /**
     * $properties is assumed to be a key => value array.
     *
     * @param array $properties
     * @param string $property_delimiter
     * @param string $comment_prefix
     * @return KeyValueCollection
     */
    public function properties(array $properties, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection;
}
