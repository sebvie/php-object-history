<?php

namespace PhpObjectHistory\Formatter;


class ObjectFormatterHandler implements ObjectFormatterHandlerInterface
{

    /**
     * @var ObjectFormatterInterface[]
     */
    protected $formatters;

    /**
     */
    public function __construct()
    {
        $this->formatters[] = new DatetimeFormatter();
    }

    /**
     * @param object $object
     * @return string
     * @throws FormatterException
     */
    public function format(object $object): string
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supportsInput($object)) {
                return $formatter->format($object);
            }
        }

        throw new FormatterException('no formatter found for object ' . get_class($object));
    }

    /**
     * @return ObjectFormatterInterface[]
     */
    public function getFormatters(): array
    {
        return $this->formatters;
    }

    /**
     * @param ObjectFormatterInterface[] $formatters
     * @return ObjectFormatterHandler
     */
    public function setFormatters(array $formatters): ObjectFormatterHandler
    {
        $this->formatters = $formatters;
        return $this;
    }

    /**
     * @param ObjectFormatterInterface $formatter
     * @return ObjectFormatterHandler
     */
    public function addFormatter(ObjectFormatterInterface $formatter): ObjectFormatterHandler
    {
        $this->formatters[] = $formatter;
        return $this;
    }
}