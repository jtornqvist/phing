<?php

namespace Phing\Test\Task\System\Properties;

use InvalidArgumentException;
use Phing\Task\System\Properties\KeyValue;
use Phing\Task\System\Properties\PropertiesImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 * @author Joakim Tärnqvist <jocke@tornqvistarna.se>
 */
class PropertiesImmutableTest extends TestCase
{
    public function testConstructor()
    {
        $Properties = new PropertiesImmutable();
        $this->assertInstanceOf(PropertiesImmutable::class, $Properties);
    }

    public function testValidPropertiesInConstructor()
    {
        $Property = $this->createMock(KeyValue::class);
        $Property->method('property')->willReturn('username');
        $Property->method('value')->willReturn('john');
        $Property->method('string')->with('=')->willReturn('username=john');

        $Properties = new PropertiesImmutable([$Property]);
        $this->assertInstanceOf(PropertiesImmutable::class, $Properties);

    }

    public function testInvalidPropertiesInConstructor()
    {
        $this->expectException(InvalidArgumentException::class);
        $Properties = new PropertiesImmutable(['key' => 'value']);
    }

    public function testProperties()
    {
        $OldProperties = new PropertiesImmutable();
        $UsernameProperty = $this->createMock(KeyValue::class);
        $UsernameProperty->method('property')->willReturn('username');
        $UsernameProperty->method('value')->willReturn('john');
        $UsernameProperty->method('string')->with('=')->willReturn('username=john');

        $PasswordProperty = $this->createMock(KeyValue::class);
        $PasswordProperty->method('property')->willReturn('password');
        $PasswordProperty->method('value')->willReturn('doe');
        $PasswordProperty->method('string')->with('=')->willReturn('password=doe');

        $NewProperties = $OldProperties->add($UsernameProperty);
        $this->assertEquals(1, sizeof($NewProperties->array()));
        $this->assertEquals(0, sizeof($OldProperties->array()));
        $this->assertEquals('username=john'.PHP_EOL, $NewProperties->string());
        $NewProperties = $NewProperties->add($PasswordProperty);
        $this->assertEquals('username=john'.PHP_EOL.'password=doe'.PHP_EOL, $NewProperties->string());
    }

    public function testRemove()
    {
        $UsernameProperty = $this->createMock(KeyValue::class);
        $UsernameProperty->method('property')->willReturn('username');
        $UsernameProperty->method('value')->willReturn('john');
        $UsernameProperty->method('string')->with('=')->willReturn('username=john');

        $PasswordProperty = $this->createMock(KeyValue::class);
        $PasswordProperty->method('property')->willReturn('password');
        $PasswordProperty->method('value')->willReturn('doe');
        $PasswordProperty->method('string')->with('=')->willReturn('password=doe');

        $Properties = new PropertiesImmutable([$UsernameProperty, $PasswordProperty]);
        $Properties = $Properties->remove('password');

        $this->assertEquals('username=john'.PHP_EOL, $Properties->string());
    }
}
