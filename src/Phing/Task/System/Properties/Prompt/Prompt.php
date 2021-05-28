<?php


namespace Phing\Task\System\Properties\Prompt;


interface Prompt
{

    public function prompt($message, $default_value): string;

}
