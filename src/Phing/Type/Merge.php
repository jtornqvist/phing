<?php

namespace Phing\Type;

use Phing\Type\Element\FileListAware;

class Merge extends DataType
{
    use FileListAware;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $prompt = '';

    /**
     * @var Merge
     */
    protected $merge;

    public function __construct($type = null)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function setPrompt(string $prompt): void
    {
        $this->prompt = $prompt;
    }

    public function getMerge(): Merge
    {
        return $this->merge;
    }

    public function addMerge(Merge $merge): void
    {
        $this->merge = $merge;
    }
}
