<?php

namespace PhpObjectHistory\Formatter;


class ToStringFormatter implements ObjectFormatterInterface
{

    /**
     * @param object $object
     * @return string
     */
    public function format(object $object): string
    {
        return $object->__toString();
    }

    /**
     * @param object $object
     * @return bool
     */
    public function supports(object $object): bool
    {
        return method_exists($object, '__toString');
    }
}