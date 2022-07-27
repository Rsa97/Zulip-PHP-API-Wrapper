<?php

namespace Rsa97\Zulip;

use Rsa97\Zulip\Exceptions\WebhookErrorException;

class Webhook
{
    use Parseable;

    #[Parseable('data')]
    public readonly string $data;
    #[Parseable('bot_email')]
    public readonly string $botEmail;
    #[Parseable('bot_full_name')]
    public readonly string $botFullName;
    #[Parseable('token')]
    public readonly string $token;
    #[Parseable('trigger', type: 'class', class: 'WebhookTrigger')]
    public readonly WebhookTrigger $trigger;
    #[Parseable('message', type: 'method', method: 'parseMessage')]
    public readonly Message $message;

    protected static function parseMessage(object $source): Message
    {
        $source->type = isset($source->streamId)
            ? RecipientType::STREAM->value
            : RecipientType::PRIVATE->value;
        return Message::from($source);
    }

    public static function getPayload(): self
    {
        $content = file_get_contents('php://input');
        $json = json_decode($content);
        if (!($json instanceof \stdClass)) {
            throw new WebhookErrorException('Invalid webhook content');
        }
        return static::from($json);
    }

    public static function withoutAnswer(): void
    {
        header('Content-Type: application/json');
        echo json_encode(
            (object)['response_not_required' => true],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    public static function answer(string $content): void
    {
        header('Content-Type: application/json');
        echo json_encode(
            (object)['content' => $content],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}
