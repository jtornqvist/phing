<?php

namespace Phing\Io\File;

use Phing\Io\File;
use Phing\Io\FileWriter;
use Phing\Io\IOException;

class Backup implements Output
{
    /**
     * @var Prefix
     */
    private $Prefix;

    /**
     * BackupPrefixStrategy constructor.
     */
    public function __construct(Prefix $Prefix)
    {
        $this->Prefix = $Prefix;
    }

    /**
     * @throws IOException
     */
    public function write(File $File, string $content): bool
    {
        if ($File->exists()) {
            $BackupFile = new File($File->getParentFile(), $this->Prefix->prefix().$File->getName());
            $File->copyTo($BackupFile);
        }

        $FileWriter = new FileWriter($File);

        $FileWriter->write($content);

        $FileWriter->close();

        return true;
    }
}
