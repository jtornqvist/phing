<?php

namespace Phing\Task\System\Properties\Merge;

use Phing\Task\System\Properties\Factory as IPropertiesFactory;
use Phing\Task\System\Properties\KeyValueCollection;
use Phing\Task\System\Properties\Prompt\Prompt;
use Phing\Task\System\Properties\Property;

/**
 * Class MergePropertiesFactory.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
class MergePropertiesFactory implements Factory
{
    /**
     * @var IPropertiesFactory
     */
    private $PropertiesFactory;

    /**
     * @var Merge
     */
    private $MergeProperties;

    /**
     * @var Prompt
     */
    private $Prompt;

    /**
     * MergePropertiesFactory constructor.
     */
    public function __construct(IPropertiesFactory $PropertiesFactory, Merge $MergeProperties, Prompt $Prompt)
    {
        $this->PropertiesFactory = $PropertiesFactory;
        $this->MergeProperties = $MergeProperties;
        $this->Prompt = $Prompt;
    }

    public function merge(string $dir, array $files, string $merge_type, string $prompt = null): KeyValueCollection
    {
        $first_pass = true;
        $Properties = null;
        foreach ($files as $filename) {
            if ($first_pass) {
                $Properties = $this->PropertiesFactory->read($dir, $filename);
                $first_pass = false;

                continue;
            }

            if (!empty($prompt)) {
                $CurrentProperties = $this->PropertiesFactory->read($dir, $filename);

                $PromptProperties = $this->MergeProperties->merge(
                    $prompt,
                    $Properties,
                    $CurrentProperties,
                );

                $properties = $PromptProperties->array();
                foreach ($properties as $Property) {
                    $value = $this->Prompt->prompt($Property->property(), $Property->value());
                    $NewProperty = new Property($Property->property(), $value);
                    if (!$NewProperty->equals($Property)) {
                        $PromptProperties = $PromptProperties->add($NewProperty);
                    }
                }

                $Properties = $this->MergeProperties->merge(
                    $merge_type,
                    $CurrentProperties,
                    $PromptProperties,
                );
            } else {
                $Properties = $this->MergeProperties->merge(
                    $merge_type,
                    $this->PropertiesFactory->read($dir, $filename),
                    $Properties,
                );
            }
        }


        return $Properties;
    }
}
