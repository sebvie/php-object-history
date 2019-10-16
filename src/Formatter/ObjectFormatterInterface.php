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
     * @param object $object
     * @return bool
     */
    public function supports(object $object): bool;
}