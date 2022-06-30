<?php

namespace Rsa97\Zulip;

class Message implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable(null, required: true, type: 'class', class: 'Recipient')]
    #[Jsonable(null, type: 'class')]
    public readonly Recipient $recipient;
    #[Parseable('content', required: true)]
    #[Jsonable('content')]
    public readonly string $content;
    #[Parseable('avatar_url')]
    public readonly string $avatarUrl;
    #[Parseable('client')]
    public readonly string $client;
    #[Parseable('content_type')]
    public readonly string $contentType;
    #[Parseable('edit_history', type: 'array', class: 'EditHistoryRecord')]
    public readonly array $editHistory;
    #[Parseable('id')]
    public readonly int $id;
    #[Parseable('is_me_message')]
    public readonly bool $isMeMessage;
    #[Parseable('last_edit_timestamp', type: 'timestamp')]
    public readonly \DateTimeImmutable $lastEditTimestamp;
    #[Parseable('reactions', type: 'array', class: 'Reaction')]
    public readonly array $reactions;
    #[Parseable('recipient_id')]
    public readonly int $recipientId;
    #[Parseable(null, type: 'method', method: 'parseSender')]
    public readonly User $sender;
    #[Parseable('sender_realm')]
    public readonly string $senderRealm;
    #[Parseable('submessages')]
    public readonly array $submessages;
    #[Parseable('timestamp', type: 'timestamp')]
    public readonly \DateTimeImmutable $timestamp;
    #[Parseable('topic_links', type: 'array', class: 'TopicLink')]
    public readonly array $topicLinks;
    #[Parseable('flags', type: 'array', class: 'MessageFlag')]
    public readonly array $flags;
    #[Parseable(null, type: 'class', class: 'Matches')]
    public readonly Matches $matches;

    public function __construct(Recipient $recipient, string $content)
    {
        $this->recipient = $recipient;
        $this->content = $content;
    }

    protected static function parseSender(object $message) {
        return User::from((object)[
            'id' => $message->sender_id,
            'email' => $message->sender_email,
            'full_name' => $message->sender_full_name
        ]);
    }
}
