<?php

namespace PhpObjectHistory\Formatter;

interface ObjectFormatterHandlerInterface
{

    /**
     * @param object $object
     * @return string
     */
    public function format(object $object): string;

}