<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Formatter\ObjectFormatterHandlerInterface;

interface ComparatorInterface
{
    /**
     * @param mixed $oldValue
     * @param mixed $newValue
     * @return ObjectChange[]
     */
    public function getDiff($oldValue, $newValue): array;

    /**
     * @param ObjectFormatterHandlerInterface $objectFormatterHandler
     * @return ComparatorInterface
     */
    public function setObjectFormatterHandler(ObjectFormatterHandlerInterface $objectFormatterHandler): ComparatorInterface;


    /**
     * @return ObjectFormatterHandlerInterface
     */
    public function getObjectFormatterHandler(): ObjectFormatterHandlerInterface;


    /**
     * @return array
     */
    public function getIgnoreAttributes(): array;


    /**
     * @param array $ignoreAttributes
     * @return ComparatorInterface
     */
    public function setIgnoreAttributes(array $ignoreAttributes): ComparatorInterface;

}