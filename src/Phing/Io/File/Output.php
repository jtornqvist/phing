<?php


namespace Phing\Io\File;


use Phing\Io\File;

interface Output
{

    public function write(File $File, string $content): bool;

}
