<?php


namespace Wren\Exception;


final class UndefinedOffsetException extends \RuntimeException
{
    public function __construct($offset, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('Notice: Undefined offset: "%s"', $offset), $code, $previous);
    }
}