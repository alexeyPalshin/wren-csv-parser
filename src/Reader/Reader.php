<?php


namespace Wren\Reader;


use SplFileObject;

abstract class Reader
{
    /**
     * Check whether file exists, readable and has valid extension
     * @return bool
     */
    public function canBeProcessed($filePath): bool
    {
        return is_readable($filePath) && (pathinfo($filePath, PATHINFO_EXTENSION) === $this->extension);
    }

    protected function open($filePath)
    {
        return new SplFileObject($filePath);
    }
}