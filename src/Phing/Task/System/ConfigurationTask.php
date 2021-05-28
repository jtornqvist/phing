<?php

namespace Phing\Task\System;

use DateTimeZone;
use Phing\Io\File;
use Phing\Io\File\Backup;
use Phing\Io\File\DatePrefix;
use Phing\Io\File\NoBackup;
use Phing\Io\IniFileParser;
use Phing\Io\IOException;
use Phing\Project;
use Phing\Task;
use Phing\Task\System\Properties\Merge\MergeProperties;
use Phing\Task\System\Properties\Merge\MergePropertiesFactory;
use Phing\Task\System\Properties\Merge\MergePropertiesPrioritizeRight;
use Phing\Task\System\Properties\Merge\PrioritizeRight;
use Phing\Task\System\Properties\Prompt\ConsolePrompt;
use Phing\Task\System\Properties\PropertiesFactory;
use Phing\Task\System\Properties\PropertiesImmutable;
use Phing\Type\Element\MergeAware;

/**
 * Merge two or more configuration files (key/value) into one.
 *
 * Typical use case is merging (new) settings from
 * an example configuration file in a repository into
 * a production configuration file.
 *
 * The settings can either be merged automatically using
 * the values in the example file or "manually" by prompting the user
 * for a value, using the example file value as default.
 *
 * Values in subsequent files will override previous files
 * when merging.
 *
 * Example:
 * - In this example we're merging two files: example.properties and prod.properties.
 * - The user is prompted to enter values for the difference (prompt="difference")
 * between example and prod.
 * - The result is then merged with prod.properties (type="union").
 * - The end result is then written to prop.properties after it has been backed up (backup="true").
 *
 * <configuration application="MyApplication" outputdir="/tmp" outputfile="prod.properties" backup="true">
 *   <merge type="union" prompt="difference">
 *     <filelist dir="/tmp" files="example.properties,prod.properties" />
 *   </merge>
 * </configuration>.
 *
 * @author Joakim Tärnqvist <jocke@tornqvistarna.se>
 */
class ConfigurationTask extends Task
{
    use MergeAware;

    /**
     * A name identifying this configuration to the user.
     *
     * @var string
     */
    private $application = 'Application config';

    /**
     * @var string
     */
    private $outputdir;

    /**
     * @var string
     */
    private $outputfile;

    /**
     * Create a backup of the outpufile.
     *
     * @var bool
     */
    private $backup = true;

    /**
     * The date format used for the prefix
     * for the backup file name.
     *
     * @var string
     */
    private $backupprefixformat = 'Ymd_His_';

    /**
     * @throws IOException
     */
    public function main()
    {
        $this->log($this->application, Project::MSG_INFO);

        $PropertiesFactory = new PropertiesFactory(new IniFileParser());
        $MergeProperties = new MergeProperties();
        $ConsolePrompt = new ConsolePrompt($this->project->getInputHandler());

        $MergePropertiesFactory = new MergePropertiesFactory(
            $PropertiesFactory,
            $MergeProperties,
            $ConsolePrompt
        );

        $directories_and_files = [];

        foreach ($this->getMerge()->getFileLists() as $filelist) {
            foreach ($filelist->filenames as $filename) {
                $directories_and_files[(string) $filelist->dir][] = $filename;
            }
        }

        $Properties = new PropertiesImmutable();
        foreach ($directories_and_files as $dir => $files) {
            $Properties = $MergeProperties->union($Properties, $MergePropertiesFactory->merge($dir, $files, $this->getMerge()->getType(), $this->getMerge()->getPrompt()));
        }

        $OutputFile = new File($this->outputdir, $this->outputfile);
        $Write = new NoBackup();
        if ($this->backup) {
            $Write = new Backup(new DatePrefix($this->backupprefixformat, new DateTimeZone(date_default_timezone_get())));
        }

        $Write->write($OutputFile, $Properties->string());

    }

    public function setApplication(string $application): void
    {
        $this->application = $application;
    }

    public function setOutputfile(string $outputfile): void
    {
        $this->outputfile = $outputfile;
    }

    public function setOutputdir(string $outputdir): void
    {
        $this->outputdir = $outputdir;
    }

    public function setBackup(bool $backup): void
    {
        $this->backup = $backup;
    }

    public function setBackupprefixformat(string $backupprefixformat): void
    {
        $this->backupprefixformat = $backupprefixformat;
    }
}
