<?php

namespace Phing\Task\System\Properties\Prompt;

/**
 * Interface Prompt.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
interface Prompt
{
    public function prompt($message, $default_value): string;
}
