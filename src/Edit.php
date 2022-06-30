<?php

namespace Rsa97\Zulip;

class Edit implements \JsonSerializable
{
    use Jsonable;

    public readonly int $messageId;
    #[Jsonable('stream_id')]
    public readonly int $streamId;
    #[Jsonable('topic')]
    public readonly string $topic;
    #[Jsonable('propagate_mode', type: 'enum')]
    public readonly EditPropagateMode $propagateMode;
    #[Jsonable('send_notification_to_old_thread')]
    public readonly bool $notifyOldThread;
    #[Jsonable('send_notification_to_new_thread')]
    public readonly bool $notifyNewThread;
    #[Jsonable('content')]
    public readonly string $content;

    public function __construct(int $messageId)
    {
        $this->messageId = $messageId;
    }

    public function moveToTopic(string $topic): self
    {
        $this->topic = $topic;
        return $this;
    }

    public function setPropagateMode(EditPropagateMode $propagateMode): self
    {
        $this->propagateMode = $propagateMode;
        return $this;
    }

    public function notNotifyOldThread(): self
    {
        $this->notifyOldThread = false;
        return $this;
    }

    public function notNotifyNewThread(): self
    {
        $this->notifyNewThread = false;
        return $this;
    }

    public function setNewContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function moveToStream(int $streamId): self
    {
        $this->streamId = $streamId;
        return $this;
    }
}
