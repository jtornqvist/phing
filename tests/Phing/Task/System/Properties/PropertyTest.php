<?php

namespace Phing\Test\Task\System\Properties;

use Phing\Task\System\Properties\Property;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PropertyTest extends TestCase
{
    public function testBooleanProperty()
    {
        $Property = new Property('property', true);
        $this->assertEquals('property=true', $Property->string('='));
    }

    public function testNullProperty()
    {
        $Property = new Property('property', null);
        $this->assertEquals('property=', $Property->string('='));
    }

    public function testZeroPaddedInteger()
    {
        $Property = new Property('property', '001');
        $this->assertEquals('property=001', $Property->string('='));
    }
}
