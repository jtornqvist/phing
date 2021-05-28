<?php

namespace Phing\Test\Task\System\Properties\Merge;

use Phing\Task\System\Properties\Merge\MergeProperties;
use Phing\Task\System\Properties\PropertiesImmutable;
use Phing\Task\System\Properties\Property;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class MergePropertiesTest extends TestCase
{
    public function testUnionUniqueProperties()
    {
        $p1 = new Property('username', 'john');
        $p2 = new Property('lastname', 'doe');
        $p3 = new Property('password', 'secret');
        $left = [$p1, $p2];
        $LeftProperties = new PropertiesImmutable($left);
        $right = [$p3];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->union($LeftProperties, $RightProperties);
        $expected = [
            'username' => 'john',
            'lastname' => 'doe',
            'password' => 'secret',
        ];
        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

    public function testUnionOverridingProperties()
    {
        $p1 = new Property('username', 'john');
        $p2 = new Property('lastname', 'doe');
        $p3 = new Property('password', 'secret');
        $p4 = new Property('password', 'new_secret');
        $p5 = new Property('email', 'john.doe@example.com');

        $left = [$p1, $p2, $p3];
        $LeftProperties = new PropertiesImmutable($left);

        $right = [$p4, $p5];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->union($LeftProperties, $RightProperties);

        $expected = [
            'username' => 'john',
            'lastname' => 'doe',
            'password' => 'secret',
            'email' => 'john.doe@example.com',
        ];

        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

    public function testIntersectionLeftOverridesRight()
    {
        $p1 = new Property('username', 'john');
        $p2 = new Property('lastname', 'doe');
        $p3 = new Property('password', 'secret');
        $p5 = new Property('email', 'john.doe@example.com');

        $p4 = new Property('password', 'new_secret');
        $p6 = new Property('email', 'john.doe@example.org');
        $p7 = new Property('favorite_colour', 'blue');

        $left = [$p1, $p2, $p3, $p5];
        $LeftProperties = new PropertiesImmutable($left);

        $right = [$p6, $p4, $p7];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->intersection($LeftProperties, $RightProperties);

        $expected = [
            'password' => 'secret',
            'email' => 'john.doe@example.com',
        ];

        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

    public function testEqualProperties()
    {
        $p1 = new Property('boolean', true);
        $p2 = new Property('boolean', 'true');

        $left = [$p1];
        $LeftProperties = new PropertiesImmutable($left);

        $right = [$p2];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->difference($LeftProperties, $RightProperties);

        $expected = [];

        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

    public function testDifferenceLeftPropertiesPreserved()
    {
        $p1 = new Property('username', 'john');
        $p2 = new Property('lastname', 'doe');
        $p3 = new Property('password', 'secret');
        $p5 = new Property('email', 'john.doe@example.com');

        $p4 = new Property('password', 'new_secret');
        $p6 = new Property('email', 'john.doe@example.org');
        $p7 = new Property('favorite_colour', 'blue');

        $left = [$p1, $p2, $p3, $p5];
        $LeftProperties = new PropertiesImmutable($left);

        $right = [$p6, $p4, $p7];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->difference($LeftProperties, $RightProperties);

        $expected = [
            'username' => 'john',
            'lastname' => 'doe',
        ];

        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

    public function testReverseDifferenceLeftPropertiesPreserved()
    {
        $p1 = new Property('username', 'john');
        $p2 = new Property('lastname', 'doe');
        $p3 = new Property('password', 'secret');
        $p5 = new Property('email', 'john.doe@example.com');

        $p4 = new Property('password', 'new_secret');
        $p6 = new Property('email', 'john.doe@example.org');
        $p7 = new Property('favorite_colour', 'blue');

        $left = [$p1, $p2, $p3, $p5];
        $LeftProperties = new PropertiesImmutable($left);

        $right = [$p6, $p4, $p7];
        $RightProperties = new PropertiesImmutable($right);

        $Merge = new MergeProperties();

        $MergeProperties = $Merge->difference($RightProperties, $LeftProperties);

        $expected = [
            'favorite_colour' => 'blue',
        ];

        $this->assertEquals($expected, $MergeProperties->key_value_array());
    }

}
