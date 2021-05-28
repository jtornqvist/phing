<?php

namespace Phing\Task\System\Properties\Merge;

use Phing\Task\System\Properties\KeyValueCollection;

/**
 * Class MergePropertiesPrioritizeRight.
 *
 * This property merge strategy will
 * prioritize right property values
 * in case of conflicting values.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
class MergePropertiesPrioritizeRight implements Merge
{
    public function union(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        $properties = $RightProperties;
        foreach ($LeftProperties->array() as $key => $value) {
            if (!$properties->property_exists($key)) {
                $properties = $properties->add($value);
            }
        }

        return $properties;
    }

    public function intersection(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        $result = $RightProperties;
        foreach ($LeftProperties->array() as $property => $value) {
            if (!$result->property_exists($property)) {
                $result = $result->remove($property);
            }
        }

        foreach ($result->array() as $property => $value) {
            if (!$LeftProperties->property_exists($property)) {
                $result = $result->remove($property);
            }
        }

        return $result;
    }

    public function difference(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        $result = $LeftProperties;
        foreach ($result->array() as $property => $value) {
            if ($RightProperties->property_exists($property)) {
                $result = $result->remove($property);
            }
        }

        return $result;
    }

    public function merge(string $type, KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        if (!in_array($type, get_class_methods($this))) {
            throw new \InvalidArgumentException('Unknown merge type: '.$type);
        }

        return $this->{$type}($LeftProperties, $RightProperties);
    }
}
