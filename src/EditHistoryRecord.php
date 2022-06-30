<?php

namespace Rsa97\Zulip;

class EditHistoryRecord
{
    use Parseable;

    #[Parseable('topic')]
    public readonly string $topic;
    #[Parseable('prev_topic')]
    public readonly string $prevTopic;
    #[Parseable('stream')]
    public readonly int $streamId;
    #[Parseable('prev_stream')]
    public readonly int $prevStreamId;
    #[Parseable('content')]
    public readonly string $content;
    #[Parseable('rendered_content')]
    public readonly string $renderedContent;
    #[Parseable('prev_content')]
    public readonly string $prevContent;
    #[Parseable('prev_rendered_content')]
    public readonly string $prevRenderedContent;
    #[Parseable('timestamp', type: 'timestamp')]
    public readonly \DateTimeImmutable $timestamp;
    #[Parseable('user_id')]
    public readonly int $userId;
    #[Parseable('content_html_diff')]
    public readonly string $contentHTMLDiff;
}
