<?php


namespace Phing\Task\System\Properties\File;


interface PropertyFile
{

    public function read($dir, $filename);
}
