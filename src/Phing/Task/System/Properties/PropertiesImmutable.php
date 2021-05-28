<?php

namespace Phing\Task\System\Properties;

use ArrayIterator;

class PropertiesImmutable implements KeyValueCollection
{
    /**
     * @var ArrayIterator
     */
    private $array;

    /**
     * @var string
     */
    private $property_value_delimiter;

    /**
     * Properties constructor.
     */
    public function __construct(array $array = null, string $property_value_delimiter = '=')
    {
        $this->property_value_delimiter = $property_value_delimiter;

        $this->array = new ArrayIterator();

        if (!is_null($array)) {
            foreach ($array as $object) {
                if (!$object instanceof KeyValue) {
                    throw new \InvalidArgumentException('Expected instance of Phing\\Task\\System\\Properties\\KeyValue');
                }
                $this->array->offsetSet($object->property(), $object);
            }
        }

    }

    public function array(): array
    {
        return $this->array->getArrayCopy();
    }

    public function key_value_array(): array
    {
        $this->array->rewind();

        $array = [];
        while ($this->array->valid()) {
            $property = $this->array->current();
            $array[$property->property()] = $property->value();
            $this->array->next();
        }

        return $array;
    }

    public function string(string $EOL = PHP_EOL): string
    {
        $this->array->rewind();
        $str = '';
        while ($this->array->valid()) {
            $str .= $this->array->current()->string($this->property_value_delimiter);
            $this->array->next();
            $str .= $EOL;
        }

        return $str;
    }

    public function property_exists(string $property): bool
    {
        return $this->array->offsetExists($property);
    }

    public function remove(string $property): KeyValueCollection
    {
        $iterator = new ArrayIterator($this->array->getArrayCopy());
        $iterator->offsetUnset($property);

        return new PropertiesImmutable($iterator->getArrayCopy(), $this->property_value_delimiter);
    }

    public function add(KeyValue $property): KeyValueCollection
    {
        $array = $this->array->getArrayCopy();
        $array[] = $property;

        return new PropertiesImmutable($array, $this->property_value_delimiter);
    }

    public function property_delimiter(): string
    {
        return $this->property_value_delimiter;
    }

    public function size(): int
    {
        return $this->array->count();
    }
}
