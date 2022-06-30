<?php

namespace Rsa97\Zulip;

class UserStatus implements \JsonSerializable
{
    public readonly ?string $text;
    public readonly ?bool $isAway;
    public readonly ?Reaction $reaction;

    public function setAway(bool $isAway): self
    {
        $this->isAway = $isAway;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function setReaction(Reaction $reaction): self
    {
        $this->reaction = $reaction;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        if (isset($this->reaction)) {
            $data = $this->reaction->jsonSerialize();
        }
        if (isset($this->text)) {
            $data['status_text'] = $this->text;
        }
        if (isset($this->isAway)) {
            $data['away'] = json_encode($this->isAway);
        }
        return $data;
    }
}
