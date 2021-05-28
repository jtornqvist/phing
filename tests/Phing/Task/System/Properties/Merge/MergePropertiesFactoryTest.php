<?php

namespace Phing\Test\Task\System\Properties\Merge;

use Phing\Task\System\Properties\Factory as IPropertiesFactory;
use Phing\Task\System\Properties\Merge\MergeProperties;
use Phing\Task\System\Properties\Merge\MergePropertiesFactory;
use Phing\Task\System\Properties\Prompt\Prompt;
use Phing\Task\System\Properties\PropertiesImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 * @coversNothing
 */
class MergePropertiesFactoryTest extends TestCase
{
    public function testUnionMergeRight()
    {
        $ExampleProperties = PropertiesImmutable::instantiate(
            [
                'server.port' => 8080,
                'character.encoding' => 'UTF-8',
                'third_party_uri' => 'example.com',
            ],
            '='
        );

        $ProductionProperties = PropertiesImmutable::instantiate(
            [
                'server.port' => 443,
                'server.servlet.context-path' => '/path',
                'timezone' => 'UTC',
            ],
            '='
        );

        $PropertiesFactory = $this->createMock(IPropertiesFactory::class);
        $map = [
            ['/tmp', 'example', '=', '#', $ExampleProperties],
            ['/tmp', 'production', '=', '#', $ProductionProperties],
        ];
        $PropertiesFactory->expects($this->any())->method('read')->will($this->returnValueMap($map));

        $Prompt = $this->createMock(Prompt::class);
        $Prompt->method('prompt')->will($this->onConsecutiveCalls('userinput #1', 'userinput #2'));

        $MergeProperties = new MergeProperties();
        $MergePropertiesFactoryTest = new MergePropertiesFactory($PropertiesFactory, $MergeProperties, $Prompt);

        $expected = [
            'server.port' => 443,
            'server.servlet.context-path' => '/path',
            'timezone' => 'UTC',
            'character.encoding' => 'UTF-8',
            'third_party_uri' => 'example.com',
        ];
        $OutputProperties = $MergePropertiesFactoryTest->merge('/tmp', ['example', 'production'], 'union');

        $this->assertEquals($expected, $OutputProperties->key_value_array());
    }

    public function testUnionMergeRightUserPrompt()
    {
        $ExampleProperties = PropertiesImmutable::instantiate(
            [
                'server.port' => 8080,
                'server.servlet.context-path' => '/path',
                'character.encoding' => 'UTF-8',
                'third_party_uri' => 'example.com',
            ],
            '='
        );

        $ProductionProperties = PropertiesImmutable::instantiate(
            [
                'server.port' => 443,
                'server.servlet.context-path' => '/path',
                'timezone' => 'UTC',
            ],
            '='
        );

        $PropertiesFactory = $this->createMock(IPropertiesFactory::class);
        $property_factory_map = [
            ['/tmp', 'example', '=', '#', $ExampleProperties],
            ['/tmp', 'production', '=', '#', $ProductionProperties],
        ];
        $PropertiesFactory->expects($this->any())->method('read')->will($this->returnValueMap($property_factory_map));

        $Prompt = $this->createMock(Prompt::class);
        $prompt_map = [
            ['character.encoding', 'UTF-8', 'userinput #1'],
            ['third_party_uri', 'example.com', 'userinput #2'],
        ];
        $Prompt->expects($this->any())->method('prompt')->will($this->returnValueMap($prompt_map));

        $MergeProperties = new MergeProperties();
        $MergePropertiesFactoryTest = new MergePropertiesFactory($PropertiesFactory, $MergeProperties, $Prompt);

        $expected = [
            'server.port' => 443,
            'server.servlet.context-path' => '/path',
            'timezone' => 'UTC',
            'character.encoding' => 'userinput #1',
            'third_party_uri' => 'userinput #2',
        ];
        $OutputProperties = $MergePropertiesFactoryTest->merge('/tmp', ['example', 'production'], 'union', 'difference');

        $this->assertEquals($expected, $OutputProperties->key_value_array());
    }
}
