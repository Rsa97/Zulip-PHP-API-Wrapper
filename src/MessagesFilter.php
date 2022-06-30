<?php

namespace Rsa97\Zulip;

class MessagesFilter implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable('anchor', type: 'method', method: 'jsonAnchor')]
    public readonly int|AnchorType $anchor;
    #[Jsonable('num_before')]
    public readonly int $before;
    #[Jsonable('num_after')]
    public readonly int $after;
    #[Jsonable('narrow', type: 'class')]
    public readonly ?Narrow $narrow;

    public function __construct(int|AnchorType $anchor, int $before = 0, int $after = 0)
    {
        $this->anchor = $anchor;
        $this->before = $before;
        $this->after = $after;
    }

    protected function jsonAnchor(): int|string
    {
        return is_int($this->anchor) ? $this->anchor : $this->anchor->value;
    }

    public function setNarrow(Narrow $narrow): self
    {
        $this->narrow = $narrow;
        return $this;
    }
}
