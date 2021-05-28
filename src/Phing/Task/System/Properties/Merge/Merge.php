<?php

namespace Phing\Task\System\Properties\Merge;

use Phing\Task\System\Properties\KeyValueCollection;

/**
 * Interface Merge.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
interface Merge
{
    /**
     * Merge $LeftProperties with $RightProperties.
     *
     * The returned object will contain properties from
     * both $LeftProperties and $RightProperties.
     *
     * Implementing class may decide how conflicting
     * values are treated (i.e. what value to preserve
     * or discard).
     */
    public function union(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * Merge $LeftProperties with $RightProperties.
     *
     * Only properties present in $LeftProperties and $RightProperties
     * will be preserved.
     *
     * Implementing class may decide how conflicting
     * values are treated (i.e. what value to preserve
     * or discard).
     */
    public function intersection(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * Subtract $RightProperties from $LeftProperties
     * and return an instance of KeyValueCollection.
     *
     * Implementing class may decide how conflicting
     * values are treated (i.e. what value to preserve
     * or discard).
     */
    public function difference(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * @param string union|intersect|difference $type
     */
    public function merge(string $type, KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;
}
