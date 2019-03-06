<?php


namespace Wren\Rules;


class CostLessRule implements Rule
{
    const RESTRICTION = 5;

    const FIELD_NUMBER = 4;
    
    public $name = 'costless'; 

    private static function rule($value) {
        if (isset($value[self::FIELD_NUMBER])) {
            return ($value[self::FIELD_NUMBER] < self::RESTRICTION);
        }
    }
    
    public function apply($line)
    {
        return self::rule($line);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}