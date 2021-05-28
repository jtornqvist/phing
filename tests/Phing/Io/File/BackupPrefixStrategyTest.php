<?php

namespace Phing\Test\Io\File;

use Phing\Io\File\Backup;
use Phing\Io\File\Prefix;
use Phing\Io\FileUtils;
use Phing\Io\IOException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class BackupPrefixStrategyTest extends TestCase
{
    public function testReplace()
    {
        $DatePrefixMock = $this->createMock(Prefix::class);

        $DatePrefixMock->method('prefix')->willReturn('prefix');

        $BackupPrefixStrategy = new Backup($DatePrefixMock);

        $this->assertTrue($BackupPrefixStrategy->write(__DIR__.'/../../../etc/system/io/testdir/file.txt', 'asdf'));
    }

    public function testFailedReplace()
    {
        $this->expectException(IOException::class);

        $DatePrefixMock = $this->createMock(Prefix::class);

        $DatePrefixMock->method('prefix')->willReturn('prefix');

        $BackupPrefixStrategy = new Backup($DatePrefixMock);

        $BackupPrefixStrategy->write(__DIR__.'/../../../etc/system/io/dir/file.txt', 'asdf');
    }
}
