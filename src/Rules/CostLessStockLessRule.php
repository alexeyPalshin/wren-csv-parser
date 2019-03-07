<?php


namespace Wren\Rules;


class CostLessStockLessRule extends Rule
{
    public $stockFieldOrder = 3;

    public $stockRestriction = 10;

    public $costFieldOrder = 4;

    public $costRestriction = 5;

    public function rule($value)
    {
        if ($this->isComparable($value[$this->costFieldOrder]) && $this->isComparable($value[$this->stockFieldOrder])) {
            return ($value[$this->stockFieldOrder] < $this->stockRestriction && $value[$this->costFieldOrder] < $this->costRestriction);
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

    /**
     * @param int $stockFieldOrder
     */
    public function setStockFieldOrder(int $stockFieldOrder): void
    {
        $this->stockFieldOrder = $stockFieldOrder;
    }

    /**
     * @param int $stockRestriction
     */
    public function setStockRestriction(int $stockRestriction): void
    {
        $this->stockRestriction = $stockRestriction;
    }
}