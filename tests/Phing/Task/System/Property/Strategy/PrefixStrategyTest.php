<?php

namespace Phing\Task\System\Property\Strategy;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PrefixStrategyTest extends TestCase
{
    public function testKeyValueNoPrefix()
    {
        $properties = ['key' => 'value'];
        $PrefixStrategy = new PrefixStrategy();
        $this->assertEquals($properties, $PrefixStrategy->properties($properties));
    }

    public function testKeyValueWithPrefix()
    {
        $properties = ['prefix_key' => 'value'];
        $PrefixStrategy = new PrefixStrategy();
        $this->assertEquals($properties, $PrefixStrategy->properties($properties, 'prefix'));
    }
}
