<?php

namespace Rsa97\Zulip;

class StreamProperties
{
    use Parseable;
    use Jsonable;

    #[Parseable('invite_only')]
    #[Parseable('is_private')]
    #[Jsonable('invite_only')]
    public readonly bool $isPrivate;
    #[Parseable('is_web_public')]
    #[Jsonable('is_web_public')]
    public readonly bool $isWebPublic;
    #[Parseable('history_public_to_subscribers')]
    #[Jsonable('history_public_to_subscribers')]
    public readonly bool $isHistoryPublic;
    #[Parseable('stream_post_policy', type: 'class', class: 'StreamPostPolicy')]
    #[Jsonable('stream_post_policy', type: 'enum')]
    public readonly StreamPostPolicy $postPolicy;
    #[Parseable('message_retention_days', type: 'method', method: 'parseMessageRetentionDays')]
    #[Jsonable('message_retention_days', type: 'method', method: 'jsonMessageRetentionDays')]
    public readonly int|MessageRetentionPolicy $messageRetentionDays;

    private static function parseMessageRetentionDays(int|string $source): int|MessageRetentionPolicy
    {
        return is_int($source) ? $source : MessageRetentionPolicy::from($source);
    }

    private function jsonMessageRetentionDays(): int|string
    {
        return is_int($this->messageRetentionDays) ? $this->messageRetentionDays : $this->messageRetentionDays->value;
    }

    public function setPrivate(bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    public function setWebPublic(bool $isWebPublic): self
    {
        $this->isWebPublic = $isWebPublic;
        return $this;
    }

    public function setHistoryPublic(bool $isHistoryPublic): self
    {
        $this->isHistoryPublic = $isHistoryPublic;
        return $this;
    }

    public function setPostPolicy(StreamPostPolicy $postPolicy): self
    {
        $this->postPolicy = $postPolicy;
        return $this;
    }

    public function setMessageRetentionDays(int|MessageRetentionPolicy $days): self
    {
        $this->messageRetentionDays = $days;
        return $this;
    }
}
