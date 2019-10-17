<?php

namespace PhpObjectHistory\Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @param string $relativePath
     * @return string
     */
    protected function getAbsolutePath(string $relativePath): string
    {
        return __DIR__ . '/../' . $relativePath;
    }
}