<?php

namespace PhpObjectHistory\Formatter;

use ReflectionObject;

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
     * @return array
     * @throws FormatterException
     */
    public function convertObjectToArray(object $object): array
    {
        $result = [];
        $reflectionClass = new ReflectionObject($object);
        $properties = $reflectionClass->getProperties();

        if (empty($properties)) {
            return $result;
        }

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyValue = $property->getValue($object);
            if (is_object($propertyValue)) {
                $propertyValue = $this->formatPropertyToString($propertyValue);
            }
            if (is_array($propertyValue)) {
                $propertyValue = $this->formatArrayToString($propertyValue);
            }
            $result[$property->getName()] = $propertyValue;
        }

        return $result;
    }

    /**
     * @param object $object
     * @return string
     * @throws FormatterException
     */
    protected function formatPropertyToString(object $object): string
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($object)) {
                return $formatter->format($object);
            }
        }

        throw new FormatterException('no formatter found for object ' . get_class($object));
    }

    /**
     * @param array $object
     * @return string
     */
    protected function formatArrayToString(array $object): string
    {
        $oneDimensionalArray = array();
        array_walk_recursive($object, function($a) use (&$oneDimensionalArray) {
            $oneDimensionalArray[] = $a;
        });

        return implode(',', $oneDimensionalArray);
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