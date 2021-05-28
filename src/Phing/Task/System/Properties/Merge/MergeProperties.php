<?php

namespace Phing\Task\System\Properties\Merge;

use Phing\Task\System\Properties\KeyValueCollection;

/**
 * Class MergeProperties.
 *
 * This property merge strategy will
 * prioritize LEFT properties before
 * right properties when merging.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
class MergeProperties implements Merge
{
    public function union(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        $left = $LeftProperties;
        foreach ($RightProperties->array() as $key => $value) {
            if (!$left->property_exists($key)) {
                $left = $left->add($value);
            }
        }

        return $left;
    }

    public function intersection(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection
    {
        $result = $LeftProperties;
        foreach ($RightProperties->array() as $property => $value) {
            if (!$result->property_exists($property)) {
                $result = $result->remove($property);
            }
        }

        foreach ($result->array() as $property => $value) {
            if (!$RightProperties->property_exists($property)) {
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
