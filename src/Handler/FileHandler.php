<?php


namespace Wren\Handler;


interface FileHandler
{
    /**
     *
     * @return mixed
     */
    public function process($filePath);
}