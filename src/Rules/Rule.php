<?php


namespace Wren\Rules;


use Wren\Exception\UndefinedOffsetException;

abstract class Rule
{
    /**
     * Checks if the value from fieldNumber matches the rule
     * @return bool
     */
    public function apply($line)
    {
        try {
            $result = $this->rule($line);
        } catch (\Exception $e) {
            $result = false;
        }
        return $result;
    }

    public function isComparable($value)
    {
        if (!isset($value)) {
            throw new UndefinedOffsetException($this->costFieldOrder);
        }
        if (!is_numeric($value) || empty($value)) {
            throw new \UnexpectedValueException();
        }
        return true;
    }
}