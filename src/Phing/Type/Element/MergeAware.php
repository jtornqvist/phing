<?php


namespace Phing\Type\Element;


use Phing\Type\Merge;

trait MergeAware
{

    /**
     * @var Merge
     */
    protected $merge;

    /**
     * @param Merge $Merge
     */
    public function addMerge(Merge $Merge): void
    {
        $this->merge = $Merge;
    }

    /**
     * @return Merge
     */
    public function getMerge(): Merge
    {
        return $this->merge;
    }

}
