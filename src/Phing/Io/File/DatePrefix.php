<?php


namespace Phing\Io\File;

use DateTime;
use DateTimeZone;
use Exception;

class DatePrefix implements Prefix
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var DateTimeZone
     */
    private $timezone;

    /**
     * DatePrefix constructor.
     * @param string $format
     * @param DateTimeZone $timezone
     */
    public function __construct(string $format, DateTimeZone $timezone)
    {
        $this->format = $format;
        $this->timezone = $timezone;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function prefix(): string
    {
        $Now = new DateTime(null, $this->timezone);

        return $Now->format($this->format);
    }

}
