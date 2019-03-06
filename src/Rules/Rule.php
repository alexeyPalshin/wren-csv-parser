<?php


namespace Wren\Rules;


interface Rule
{
    /**
     * Checks if the value from fieldNumber matches the rule
     * @return bool
     */
    public function apply($line);
}