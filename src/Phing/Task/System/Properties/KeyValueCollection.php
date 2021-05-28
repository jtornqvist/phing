<?php

namespace Phing\Task\System\Properties;

interface KeyValueCollection
{
    /**
     * The delimiter used for this collection
     * of properties.
     */
    public function property_delimiter(): string;

    /**
     * The number of properties.
     */
    public function size(): int;

    /**
     * An array representation of this collection.
     *
     * Each element is an instance of KeyValue::class.
     */
    public function array(): array;

    /**
     * @return array
     */
    public function key_value_array(): array;

    /**
     * @param string $property
     * @return bool
     */
    public function property_exists(string $property): bool;

    /**
     * @param string $EOL
     * @return string
     */
    public function string(string $EOL = PHP_EOL): string;

    /**
     * Remove a key/value from this collection.
     *
     * @param string $property
     * @return KeyValueCollection
     */
    public function remove(string $property): KeyValueCollection;

    /**
     * Add property/value to this collection.
     *
     * @param KeyValue $property
     * @return KeyValueCollection
     */
    public function add(KeyValue $property): KeyValueCollection;
}
