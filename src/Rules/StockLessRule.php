<?php


namespace Wren\Rules;


use Wren\Exception\UndefinedOffsetException;

class StockLessRule implements Rule
{
    const RESTRICTION = 10;

    const FIELD_NUMBER = 3;

    public $name = 'stockless';

    private static function rule($value) {

        if (isset($value[self::FIELD_NUMBER])) {
            return ($value[self::FIELD_NUMBER] < self::RESTRICTION);
        }
//        throw new UndefinedOffsetException(self::FIELD_NUMBER);
    }

    public function apply($line)
    {
        try {
            $result = self::rule($line);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        
        return  $result;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}