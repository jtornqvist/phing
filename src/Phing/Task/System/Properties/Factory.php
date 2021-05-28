<?php


namespace Phing\Task\System\Properties;


use Phing\Io\File;
use Phing\Task\System\Properties\Merge\Merge;

interface Factory
{

    /**
     * @param File $properties_file
     * @param string $property_delimiter
     * @param string $comment_prefix
     * @return KeyValueCollection
     */
    public function read_file(File $properties_file, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection;

    /**
     * @param array $properties
     * @param string $property_delimiter
     * @param string $comment_prefix
     * @return KeyValueCollection
     */
    public function properties(array $properties, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection;


}
