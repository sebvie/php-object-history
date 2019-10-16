<?php

namespace PhpObjectHistory\Formatter;

interface ObjectFormatterInterface
{

    /**
     * @param $object
     * @return string
     */
    public function format(object $object): string;

    /**
     * @return bool
     */
    public function supportsInput(object $object): bool;
}