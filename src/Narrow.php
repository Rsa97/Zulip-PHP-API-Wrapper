<?php

namespace Rsa97\Zulip;

class Narrow implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable(null, type: 'array')]
    private array $list = [];

    public function search(string $words): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::SEARCH, $words);
        return $this;
    }

    public function stream(int|string $streamId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::STREAM, $streamId);
        return $this;
    }

    public function notStream(int|string $streamId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::STREAM, $streamId, negated: true);
        return $this;
    }

    public function topic(string $topic): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::TOPIC, $topic);
        return $this;
    }

    public function notTopic(string $topic): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::TOPIC, $topic, negated: true);
        return $this;
    }

    public function is(NarrowIsOperand $operand): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::IS, $operand);
        return $this;
    }

    public function isNot(NarrowIsOperand $operand): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::IS, $operand, negated: true);
        return $this;
    }

    public function has(NarrowHasOperand $operand): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::HAS, $operand);
        return $this;
    }

    public function hasNot(NarrowHasOperand $operand): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::HAS, $operand, negated: true);
        return $this;
    }

    public function pmWith(array $users): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::PM_WITH, $users);
        return $this;
    }

    public function pmWithout(array $users): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::PM_WITH, $users, negated: true);
        return $this;
    }

    public function sender(string $user): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::SENDER, $user);
        return $this;
    }

    public function notSender(string $user): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::SENDER, $user, negated: true);
        return $this;
    }

    public function near(int $messageId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::NEAR, $messageId);
        return $this;
    }

    public function notNear(int $messageId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::NEAR, $messageId, negated: true);
        return $this;
    }

    public function id(int $messageId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::ID, $messageId);
        return $this;
    }

    public function notId(int $messageId): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::ID, $messageId, negated: true);
        return $this;
    }

    public function groupPmWith(array $users): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::GROUP_PM_WITH, $users);
        return $this;
    }

    public function groupPmWithout(array $users): self
    {
        $this->list[] = new NarrowOperation(NarrowOperator::GROUP_PM_WITH, $users, negated: true);
        return $this;
    }
}
