<?php

namespace Phing\Task\System\Properties\Prompt;

use Phing\Input\InputHandler;
use Phing\Input\InputRequest;

/**
 * Class ConsolePrompt.
 *
 * @author Joakim Törnqvist <jocke@tornqvistarna.se>
 */
class ConsolePrompt implements Prompt
{
    /**
     * @var InputHandler
     */
    private $InputHandler;

    /**
     * @var string
     */
    private $prompt_char;

    /**
     * ConsolePrompt constructor.
     */
    public function __construct(InputHandler $InputHandler, string $prompt_char = ':')
    {
        $this->InputHandler = $InputHandler;
        $this->prompt_char = $prompt_char;
    }

    public function prompt($message, $default_value): string
    {
        $request = new InputRequest($message);
        $request->setDefaultValue($default_value);
        $request->setPromptChar($this->prompt_char);
        $this->InputHandler->handleInput($request);

        return $request->getInput();
    }
}
