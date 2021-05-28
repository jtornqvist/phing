<?php

namespace Phing\Task\System\Properties;

use Phing\Io\File;
use Phing\Io\FileParserInterface;

/**
 * Class PropertiesFactory.
 *
 * @author Joakim Tärnqvist <jocke@tornqvistarna.se>
 */
class PropertiesFactory implements Factory
{
    /**
     * @var FileParserInterface
     */
    private $FileParser;

    /**
     * PropertiesFactory constructor.
     */
    public function __construct(FileParserInterface $FileParser)
    {
        $this->FileParser = $FileParser;
    }

    public function read($dir, $filename, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection
    {
        return $this->properties($this->FileParser->parseFile(new File($dir, $filename)), $property_delimiter, $comment_prefix);
    }

    public function read_file(File $properties_file, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection
    {
        return $this->properties($this->FileParser->parseFile($properties_file), $property_delimiter, $comment_prefix);
    }

    public function properties(array $properties, string $property_delimiter = '=', string $comment_prefix = '#'): KeyValueCollection
    {
        foreach ($properties as $property => $value) {
            $properties[$property] = new Property($property, $value);
        }

        return new PropertiesImmutable($properties, $property_delimiter);
    }
}
