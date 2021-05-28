<?php

namespace Phing\Task\System\Properties;

class Property implements KeyValue
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Property constructor.
     *
     * @param mixed $value
     */
    public function __construct(string $property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    public function property(): string
    {
        return (string) $this->property;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function string(string $delimiter): string
    {
        return $this->property.$delimiter.(string) $this->boolean_to_string($this->value);
    }

    public function equals(KeyValue $KeyValue): bool
    {
        return $this->string('=') === $KeyValue->string('=');
    }

    private function boolean_to_string($value)
    {
        if (is_bool($value)) {
            if ($value) {
                return 'true';
            }

            return 'false';
        }

        return $value;
    }
}
