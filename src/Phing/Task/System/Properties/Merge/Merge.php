<?php

namespace Phing\Task\System\Properties\Merge;

use Phing\Task\System\Properties\KeyValueCollection;

interface Merge
{

    /**
     * Merge $LeftProperties with $RightProperties.
     *
     * The returned object will contain properties from
     * both $LeftProperties and $RightProperties.
     * $LeftProperties values will override values
     * in $RightProperties.
     *
     * @param KeyValueCollection $LeftProperties
     * @param KeyValueCollection $RightProperties
     * @return KeyValueCollection
     */
    public function union(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * Merge $LeftProperties with $RightProperties.
     *
     * Only properties present in $LeftProperties and $RightProperties
     * will be preserved.
     * Values from $LeftProperties will be preserved.
     *
     * @param KeyValueCollection $LeftProperties
     * @param KeyValueCollection $RightProperties
     * @return KeyValueCollection
     */
    public function intersection(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * Subtract $RightProperties from $LeftProperties
     * and return an instance of KeyValueCollection.
     *
     * @param KeyValueCollection $LeftProperties
     * @param KeyValueCollection $RightProperties
     * @return KeyValueCollection
     */
    public function difference(KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;

    /**
     * @param string union|intersect|difference|addIntersection $type
     * @param KeyValueCollection $LeftProperties
     * @param KeyValueCollection $RightProperties
     * @return KeyValueCollection
     */
    public function merge(string $type, KeyValueCollection $LeftProperties, KeyValueCollection $RightProperties): KeyValueCollection;
}
