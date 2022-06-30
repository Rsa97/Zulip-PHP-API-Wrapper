<?php

namespace Rsa97\Zulip;

class PrivateRecipient extends Recipient
{
    use Parseable;
    use Jsonable;

    #[Parseable('to', required: true)]
    #[Parseable('display_recipient', required: true, type: 'method', method: 'parseIds')]
    #[Jsonable('to')]
    public readonly array $userIds;
    #[Jsonable('topic')]
    protected string $topic = '';
    #[Jsonable('type', type: 'enum')]
    public readonly RecipientType $type;

    public function __construct(array $userIds)
    {
        $this->userIds = $userIds;
        $this->type = RecipientType::PRIVATE;
    }

    protected static function parseIds(array $display): array
    {
        return array_map(
            fn($u) => $u->id,
            $display
        );
    }
}
