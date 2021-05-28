<?php

namespace Phing\Type;

use Phing\Type\Element\FileListAware;

/**
 * Merge key/value text files.
 *
 * <merge type="union" prompt="difference">
 *    <filelist ... />
 * </merge>
 *
 * @package Phing\Type
 * @author Joakim Tärnqvist <jocke@tornqvistarna.se>
 */
class Merge extends DataType
{
    use FileListAware;

    /**
     * The merge type.
     * i.e. should the files be merged using on of
     * union, intersection or difference.
     * Valid values: 'union|intersection|difference'.
     *
     * @var string
     */
    protected $type;

    /**
     * Prompt the user for property values by first
     * merging property files using union, intersection or
     * difference' and subsequently prompting the user to
     * enter values for the resulting properties.
     *
     * Valid values are 'union|intersection|difference'.
     *
     * @var string
     */
    protected $prompt;

    /**
     * Merge constructor.
     *
     * Default behaviour is to do a union merge
     * ant to not prompt the user for additional
     * input.
     *
     * @param string $type
     * @param string $prompt
     */
    public function __construct(string $type = 'union', string $prompt = '')
    {
        parent::__construct();
        $this->type = $type;
        $this->prompt = $prompt;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getType(): string
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

}
