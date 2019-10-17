<?php

namespace PhpObjectHistory\Formatter;

interface ObjectFormatterHandlerInterface
{

    /**
     * @param object $object
     * @return array
     */
    public function convertObjectToArray(object $object): array;

}