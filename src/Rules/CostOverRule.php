<?php


namespace Wren\Rules;


class CostOverRule extends Rule
{
    public $costFieldOrder = 4;

    public $costRestriction = 1000;

    public function rule($value)
    {
        if ($this->isComparable($value[$this->costFieldOrder])) {
            return ($value[$this->costFieldOrder] < $this->costRestriction);
        }
        return false;
    }

    /**
     * @param int $costFieldOrder
     */
    public function setCostFieldOrder(int $costFieldOrder): void
    {
        $this->costFieldOrder = $costFieldOrder;
    }

    /**
     * @param int $costRestriction
     */
    public function setCostRestriction(int $costRestriction): void
    {
        $this->costRestriction = $costRestriction;
    }
}