<?php

namespace Rsa97\Zulip;

class NarrowOperation implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable('operator', type: 'enum')]
    public readonly NarrowOperator $operator;
    #[Jsonable('operand', type: 'method', method: 'jsonOperand')]
    public readonly string|int|array|NarrowIsOperand|NarrowHasOperand $operand;
    #[Jsonable('negated')]
    public readonly bool $negated;

    public function __construct(
        NarrowOperator $operator,
        string|int|array|NarrowIsOperand|NarrowHasOperand $operand,
        ?bool $negated = null
    ) {
        $this->operator = $operator;
        $this->operand = $operand;
        if ($negated !== null) {
            $this->negated = $negated;
        }
    }

    private function jsonOperand(): int|string
    {
        if (is_int($this->operand) || is_string($this->operand) || is_array($this->operand)) {
            return $this->operand;
        }
        return $this->operand->value;
    }
}
