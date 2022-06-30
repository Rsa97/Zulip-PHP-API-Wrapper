<?php

namespace Rsa97\Zulip;

class Reaction implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('emoji_name', required: true)]
    #[Jsonable('emoji_name')]
    public readonly string $emojiName;
    #[Parseable('emoji_code')]
    #[Jsonable('emoji_code')]
    public readonly string $emojiCode;
    #[Parseable('reaction_type', type: 'class', class: 'ReactionType')]
    #[Jsonable('reaction_type', type: 'enum')]
    public readonly ReactionType $type;
    #[Parseable('user_id')]
    public readonly int $userId;

    public function __construct(string $emojiName)
    {
        $this->emojiName = $emojiName;
    }

    public function setEmojiCode(string $emojiCode, ReactionType $reactionType): self
    {
        $this->type = $reactionType;
        $this->emojiCode = $emojiCode;
        return $this;
    }
}
