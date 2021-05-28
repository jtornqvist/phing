<?php

namespace Phing\Task\System\Properties;

/**
 * Interface KeyValueCollection.
 *
 * @author Joakim Tärnqvist <jocke@tornqvistarna.se>
 */
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

    public function key_value_array(): array;

    public function property_exists(string $property): bool;

    public function string(string $EOL = PHP_EOL): string;

    /**
     * Remove a key/value from this collection.
     */
    public function remove(string $property): KeyValueCollection;

    /**
     * Add property/value to this collection.
     */
    public function add(KeyValue $property): KeyValueCollection;
}
