<?php


namespace Wren\Handler;


class TestFileHandler implements FileHandler
{
    public function process()
    {
        var_dump(self::class);die();
    }
}