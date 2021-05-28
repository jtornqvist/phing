<?php

namespace Phing\Io\File;

use Phing\Io\File;
use Phing\Io\FileWriter;

class NoBackup implements Output
{
    public function write(File $File, string $content): bool
    {
        $FileWriter = new FileWriter($File);

        $FileWriter->write($content);

        $FileWriter->close();

        return true;
    }
}
