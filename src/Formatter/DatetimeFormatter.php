<?php

namespace PhpObjectHistory\Formatter;

use DateTime;

class DatetimeFormatter implements ObjectFormatterInterface
{
    /**
     * @var string
     */
    protected  $format = 'c';

    /**
     * @param object $object
     * @return string
     */
    public function format(object $object): string
    {
        return $object->format($this->format);
    }

    /**
     * @param object $object
     * @return bool
     */
    public function supportsInput(object $object): bool
    {
        return $object instanceof DateTime;
    }


    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return DatetimeFormatter
     */
    public function setFormat(string $format): DatetimeFormatter
    {
        $this->format = $format;
        return $this;
    }
}