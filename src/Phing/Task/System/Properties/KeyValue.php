<?php

namespace Phing\Task\System\Properties;

/**
 * Interface KeyValue.
 */
interface KeyValue
{
    public function property(): string;

    public function value(): string;

    public function string(string $delimiter): string;

    public function equals(KeyValue $KeyValue): bool;
}
