<?php


namespace Wren\Rules;


class RulesKeeper
{
    /**
     * @var array
     */
    protected $rules = [
        [
            CostLessRule::class, 'apply'
        ],
        [
            StockLessRule::class, 'apply'
        ]
    ];

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRule(array $rule): void
    {
        $this->rules[] = $rule;
    }
}