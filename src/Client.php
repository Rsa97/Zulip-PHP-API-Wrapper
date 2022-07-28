<?php

namespace Rsa97\Zulip;

use Rsa97\Zulip\Extensions\APIErrorException;
use Rsa97\Zulip\Extensions\FileAccessErrorException;
use Rsa97\Zulip\Extensions\TransportErrorException;

use function PHPSTORM_META\map;

class Client
{
    private readonly string $apiUrl;
    private readonly string $botEmail;
    private readonly string $apiKey;

    protected function request(
        RequestType $type,
        string $endpoint,
        array $data = [],
        bool $jsonEncode = true,
        bool $raw = false
    ): object|string {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type->value);
        curl_setopt($curl, CURLOPT_USERNAME, $this->botEmail);
        curl_setopt($curl, CURLOPT_PASSWORD, $this->apiKey);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $url = "{$this->apiUrl}{$endpoint}";
        if ($jsonEncode) {
            foreach ($data as &$value) {
                if (is_array($value) || is_bool($value) || is_object($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
            }
        }
        switch ($type) {
            case RequestType::GET:
                if (count($data) > 0) {
                    $url .= '?' . implode(
                        '&',
                        array_map(
                            fn($key, $val) => urlencode($key) . '=' . urlencode($val),
                            array_keys($data),
                            array_values($data)
                        )
                    );
                }
                break;
            case RequestType::PATCH:
            case RequestType::POST:
            case RequestType::DELETE:
                if (count($data) > 0) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        if ($result === false) {
            throw new TransportErrorException(curl_error($curl), curl_errno($curl));
        }
        if ($raw) {
            return $result;
        }
        $result = json_decode($result);
        if ($result->result === 'error') {
            throw new APIErrorException($result->msg);
        }
        return $result;
    }

    protected function getRequest(string $endpoint, array $data = []): object
    {
        return $this->request(RequestType::GET, $endpoint, $data);
    }

    protected function postRequest(string $endpoint, array $data = [], bool $jsonEncode = true): object
    {
        return $this->request(RequestType::POST, $endpoint, $data, $jsonEncode);
    }

    protected function patchRequest(string $endpoint, array $data = []): object
    {
        return $this->request(RequestType::PATCH, $endpoint, $data);
    }

    protected function deleteRequest(string $endpoint, array $data = []): object
    {
        return $this->request(RequestType::DELETE, $endpoint, $data);
    }

    public function __construct(string $apiUrl, string $botEmail, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->botEmail = $botEmail;
        $this->getRequest('/api/v1/users/me');
    }

    public function sendMessage(Message $message, ?string $queueId = null, ?string $localId = null): int
    {
        $data = $message->jsonSerialize();
        if (isset($queueId)) {
            $data['queue_id'] = $queueId;
        }
        if (isset($localId)) {
            $data['local_id'] = $localId;
        }
        $result = $this->postRequest('/api/v1/messages', $data);
        return $result->id;
    }

    public function uploadFile(string $path, string $fileName): string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new FileAccessErrorException("File '{$path}' is not accessible");
        }
        $file = curl_file_create($path, mime_content_type($path), $fileName);
        $result = $this->postRequest('/api/v1/user_uploads', ['filename' => $file], jsonEncode: false);
        return $result->uri;
    }

    public function getFile(string $url): string
    {
        return $this->request(RequestType::GET, $url, raw: true);
    }

    public function editMessage(Edit $edit): void
    {
        $this->patchRequest("/api/v1/messages/{$edit->messageId}", $edit->jsonSerialize());
    }

    public function deleteMessage(int $messageId): void
    {
        $this->deleteRequest("/api/v1/messages/{$messageId}");
    }

    public function getMessages(MessagesFilter $filter, bool $showGravatar = true, bool $applyMarkdown = true): array
    {
        $data = $filter->jsonSerialize();
        $data['client_gravatar'] = $showGravatar;
        $data['apply_markdown'] = $applyMarkdown;
        $result = $this->getRequest('/api/v1/messages', $data);
        return array_map(
            fn($msg) => Message::from($msg),
            $result->messages
        );
    }

    public function addReaction(int $messageId, Reaction $reaction): void
    {
        $this->postRequest("/api/v1/messages/{$messageId}/reactions", $reaction->jsonSerialize());
    }

    public function removeReaction(int $messageId, Reaction $reaction): void
    {
        $this->deleteRequest("/api/v1/messages/{$messageId}/reactions", $reaction->jsonSerialize());
    }

    public function renderMessage(string $content): string
    {
        $result = $this->postRequest('/api/v1/messages/render', ['content' => $content]);
        return $result->rendered;
    }

    public function getMessage(int $messageId, bool $applyMarkdown = true): Message
    {
        $result = $this->getRequest("/api/v1/messages/{$messageId}", ['apply_markdown' => $applyMarkdown]);
        return Message::from($result->message);
    }

    public function checkMatches(array $messageIds, Narrow $narrow): array
    {
        $result = $this->getRequest('/api/v1/messages/matches_narrow', ['msg_ids' => $messageIds, 'narrow' => $narrow]);
        return array_map(
            fn($m) => Matches::from($m),
            (array)$result->messages
        );
    }

    public function getMessageEditHistory(int $messageId): array
    {
        $result = $this->getRequest("/api/v1/messages/{$messageId}/history");
        return array_map(
            fn($ehr) => EditHistoryRecord::from($ehr),
            $result->message_history
        );
    }

    public function addMessageFlag(array $messageIds, MessageFlag $flag): array
    {
        $result = $this->postRequest(
            '/api/v1/messages/flags',
            [
                'messages' => $messageIds,
                'op' => MessageFlagOperation::ADD->value,
                'flag' => $flag->value
            ]
        );
        return $result->messages;
    }

    public function removeMessageFlag(array $messageIds, MessageFlag $flag): array
    {
        $result = $this->postRequest(
            '/api/v1/messages/flags',
            [
                'messages' => $messageIds,
                'op' => MessageFlagOperation::REMOVE->value,
                'flag' => $flag->value
            ]
        );
        return $result->messages;
    }

    public function markAsRead(?int $streamId = null, ?string $topic = null): void
    {
        if (!isset($streamId)) {
            $this->postRequest('/api/v1/mark_all_as_read');
            return;
        }
        if (!isset($topic)) {
            $this->postRequest('/api/v1/mark_stream_as_read', ['stream_id' => $streamId]);
            return;
        }
        $this->postRequest('/api/v1/mark_topic_as_read', ['stream_id' => $streamId, 'topic_name' => $topic]);
    }

    public function getDrafts(): array
    {
        $result = $this->getRequest('/api/v1/drafts');
        return array_map(
            fn($dr) => Draft::from($dr),
            $result->drafts
        );
    }

    public function createDrafts(array $drafts): array
    {
        $result = $this->postRequest('/api/v1/drafts', ['drafts' => $drafts]);
        return $result->ids;
    }

    public function editDraft(int $draftId, Draft $draft): void
    {
        $this->patchRequest("/api/v1/drafts/{$draftId}", ['draft' => $draft]);
    }

    public function deleteDraft(int $draftId): void
    {
        $this->request(RequestType::DELETE, "/api/v1/drafts/{$draftId}");
    }

    public function getSubscriptions(bool $includeSubscribers = false): array
    {
        $result = $this->getRequest('/api/v1/users/me/subscriptions', ['include_subscribers' => $includeSubscribers]);
        return array_map(
            fn($sub) => Subscription::from($sub),
            $result->subscriptions
        );
    }

    public function subscribe(
        array $streams,
        array $principals,
        StreamProperties $properties = new StreamProperties(),
        bool $authorizationErrorsFatal = true,
        bool $announce = false,
    ): object {
        $data = array_merge(
            [
                'subscriptions' => $streams,
                'principals' => $principals,
                'authorization_errors_fatal' => $authorizationErrorsFatal,
                'announce' => $announce,
            ],
            $properties->jsonSerialize()
        );
        return $this->postRequest('/api/v1/users/me/subscriptions', $data);
    }

    public function unsubscribe(array $streams, array $principals): object
    {
        return $this->deleteRequest(
            '/api/v1/users/me/subscriptions',
            [
                'subscriptions' => array_map(
                    fn($s) => $s->name,
                    $streams
                ),
                'principals' => $principals
            ]
        );
    }

    public function isSubscribed(int $streamId, int $userId): bool
    {
        $result = $this->getRequest("/api/v1/users/{$userId}/subscriptions/{$streamId}");
        return $result->is_subscribed;
    }

    public function getSubscribers(int $streamId): array
    {
        $result = $this->getRequest("/api/v1/streams/{$streamId}/members");
        return $result->subscribers;
    }

    public function updateSubscriptionSettings(array $properties): array
    {
        $result = $this->postRequest('/api/v1/users/me/subscriptions/properties', ['subscription_data' => $properties]);
        return array_map(
            fn($p) => SubscriptionProperty::from($p),
            $result->ignored_parameters_unsupported ?? []
        );
    }

    public function getStreams(array $streamTypes = [StreamType::SUBSCRIBED, StreamType::PUBLIC],
    ): array {
        $options = [];
        foreach (StreamType::cases() as $type) {
            $options[$type->value] = in_array($type, $streamTypes);
        }
        $result = $this->getRequest('/api/v1/streams', $options);
        return array_map(
            fn($str) => Stream::from($str),
            $result->streams
        );
    }

    public function getStream(int $streamId): Stream
    {
        $result = $this->getRequest("/api/v1/streams/{$streamId}");
        return Stream::from($result->stream);
    }

    public function getStreamId(string $name): int
    {
        $result = $this->getRequest('/api/v1/get_stream_id', ['stream' => $name]);
        return $result->stream_id;
    }

    public function createStream(
        Stream $stream,
        StreamProperties $properties = new StreamProperties(),
        bool $authorizationErrorsFatal = true,
        bool $announce = false,
    ): object {
        return $this->subscribe([$stream], [$this->getMe()->email], $properties, $authorizationErrorsFatal, $announce);
    }

    public function updateStream(
        int $streamId,
        ?string $name = null,
        ?string $description = null,
        StreamProperties $properties = new StreamProperties()
    ): void {
        $data = $properties->jsonSerialize();
        if (isset($name)) {
            $data['new_name'] = $name;
        }
        if (isset($description)) {
            $data['description'] = $description;
        }
        $this->patchRequest("/api/v1/streams/{$streamId}", $data);
    }

    public function archiveStream(int $streamId): void
    {
        $this->deleteRequest("/api/v1/streams/{$streamId}");
    }

    public function getTopics(int $streamId): array
    {
        $result = $this->getRequest("/api/v1/users/me/{$streamId}/topics");
        return $result->topics;
    }

    protected function toggleTopicMute(int|string $stream, string $topic, TopicMuteOperation $op): void
    {
        $data = [
            'topic' => $topic,
            'op' => $op->value
        ];
        if (is_int($stream)) {
            $data['stream_id'] = $stream;
        } else {
            $data['stream'] = $stream;
        }
        $this->patchRequest('/api/v1/users/me/subscriptions/muted_topics', $data);
    }

    public function muteTopic(int|string $stream, string $topic): void
    {
        $this->toggleTopicMute($stream, $topic, TopicMuteOperation::MUTE);
    }

    public function unmuteTopic(int|string $stream, string $topic): void
    {
        $this->toggleTopicMute($stream, $topic, TopicMuteOperation::UNMUTE);
    }

    public function deleteTopic(int $streamId, string $topic): void
    {
        $this->postRequest("/api/v1/streams/{$streamId}/delete_topic", ['topic_name' => $topic]);
    }

    public function getUsers(bool $includeGravatar = true, bool $includeCustom = false): array
    {
        $result = $this->getRequest(
            '/api/v1/users',
            [
                'client_gravatar' => $includeGravatar,
                'include_custom_profile_fields' => $includeCustom
            ]
        );
        return array_map(
            fn($u) => User::from($u),
            $result->members
        );
    }

    public function getMe(): User
    {
        $result = $this->getRequest('/api/v1/users/me');
        return User::from($result);
    }

    public function getUser(int|string $user, bool $includeGravatar = true, bool $includeCustom = false): User
    {
        $result = $this->getRequest(
            '/api/v1/users/' . urlencode($user),
            [
                'client_gravatar' => $includeGravatar,
                'include_custom_profile_fields' => $includeCustom
            ]
        );
        return User::from($result->user);
    }

    public function updateUser(
        int $userId,
        ?string $fullName = null,
        ?OrganizationRole $role = null,
        ?array $profileData = null
    ): void {
        $data = [];
        if (isset($fullName)) {
            $data['full_name'] = $fullName;
        }
        if (isset($role)) {
            $data['role'] = $role->value;
        }
        if (isset($profileData)) {
            $data['profile_data'] = $profileData;
        }
        $this->patchRequest("/api/v1/users/{$userId}", $data);
    }

    public function setStatus(UserStatus $status): void
    {
        $this->postRequest('/api/v1/users/me/status', $status->jsonSerialize());
    }

    public function createUser(User $user, string $password): int
    {
        $data = $user->jsonSerialize();
        $data['password'] = $password;
        $result = $this->postRequest('/api/v1/users', $data);
        return $result->user_id;
    }

    public function deactivateUser(int $userId): void
    {
        $this->deleteRequest("/api/v1/users/{$userId}");
    }

    public function reactivateUser(int $userId): void
    {
        $this->postRequest("/api/v1/users/{$userId}/reactivate");
    }

    public function deactivateMe(): void
    {
        $this->deleteRequest('/api/v1/users/me');
    }

    protected function setTyping(Recipient $recipient, TypingOperation $op): void
    {
        $data = $recipient->jsonSerialize();
        $data['op'] = $op->value;
        $this->postRequest('/api/v1/typing', $data);
    }

    public function startTyping(Recipient $recipient): void
    {
        $this->setTyping($recipient, TypingOperation::START);
    }

    public function stopTyping(Recipient $recipient): void
    {
        $this->setTyping($recipient, TypingOperation::STOP);
    }

    public function getUserPresence(int|string $user): array
    {
        $usr = urlencode($user);
        $result = $this->getRequest("/api/v1/users/{$usr}/presence");
        return array_map(
            fn(object $p) => Presence::from($p),
            (array)$result->presence
        );
    }

    public function getAttachments(): array
    {
        $result = $this->getRequest('/api/v1/attachments');
        return array_map(
            fn(object $a) => Attachment::from($a),
            $result->attachments
        );
    }

    public function deleteAttachment(int $attachmentId): void
    {
        $this->deleteRequest("/api/v1/attachments/{$attachmentId}");
    }

    public function updateSettings(UserSettings $settings): array
    {
        $result = $this->patchRequest('/api/v1/settings', $settings->jsonSerialize());
        return $result->ignored_parameters_unsupported ?? [];
    }

    public function getUserGroups(): array
    {
        $result = $this->getRequest('/api/v1/user_groups');
        return array_map(
            fn($g) => UserGroup::from($g),
            $result->user_groups
        );
    }

    public function createUserGroup(UserGroup $group): void
    {
        $this->postRequest('/api/v1/user_groups/create', $group->jsonSerialize());
    }

    public function updateUserGroup(int $groupId, UserGroup $group): void
    {
        $this->patchRequest("/api/v1/user_groups/{$groupId}", $group->jsonSerialize());
    }

    public function deleteUserGroup(int $groupId): void
    {
        $this->deleteRequest("/api/v1/user_groups/{$groupId}");
    }

    public function updateUserGroupMembers(int $groupId, array $add = [], array $delete = []): void
    {
        $this->postRequest("/api/v1/user_groups/{$groupId}/members", ['add' => $add, 'delete' => $delete]);
    }

    public function updateUserGroupSubgroups(int $groupId, array $add = [], array $delete = []): void
    {
        $this->postRequest("/api/v1/user_groups/{$groupId}/subgroups", ['add' => $add, 'delete' => $delete]);
    }

    public function isMemberOf(int $userId, int $groupId, ?bool $directMemberOnly = null): bool
    {
        $data = [
            'user_id' => $userId,
            'user_group_id' => $groupId,
        ];
        if (isset($directMemberOnly)) {
            $data['direct_member_only'] = $directMemberOnly;
        }
        $result = $this->getRequest("/api/v1/user_groups/{$groupId}/members/{$userId}", $data);
        return $result->is_user_group_member;
    }

    public function getUserGroupMembers(int $groupId): array
    {
        $result = $this->getRequest("/api/v1/user_groups/{$groupId}/members");
        return $result->members;
    }

    public function getUserGroupSubgroups(int $groupId): array
    {
        $result = $this->getRequest("/api/v1/user_groups/{$groupId}/subgroups");
        return $result->members;
    }

    public function muteUser(int $userId): void
    {
        $this->postRequest("/api/v1/users/me/muted_users/{$userId}");
    }

    public function unmuteUser(int $userId): void
    {
        $this->deleteRequest("/api/v1/users/me/muted_users/{$userId}");
    }

    public function getServerSettings(): ServerSettings
    {
        $result = $this->getRequest('/api/v1/server_settings');
        return ServerSettings::from($result);
    }

    public function getLinkifiers(): array
    {
        $result = $this->getRequest('/api/v1/realm/linkifiers');
        return array_map(
            fn($l) => Linkifier::from($l),
            $result->linkifiers
        );
    }

    public function addLinkifier(Linkifier $linkifier): int
    {
        $result = $this->postRequest('/api/v1/realm/filters', $linkifier->jsonSerialize());
        return $result->id;
    }

    public function updateLinkifier(int $linkifierId, Linkifier $linkifier): void
    {
        $this->patchRequest("/api/v1/realm/filters/{$linkifierId}", $linkifier->jsonSerialize());
    }

    public function removeLinkifier(int $linkifierId): void
    {
        $this->deleteRequest("/api/v1/realm/filters/{$linkifierId}");
    }

    public function createCodePlayground(CodePlayground $playground): int
    {
        $result = $this->postRequest('/api/v1/realm/playgrounds', $playground->jsonSerialize());
        return $result->id;
    }

    public function removeCodePlayground(int $playgroundId): void
    {
        $this->deleteRequest("/api/v1/realm/playgrounds/{$playgroundId}");
    }

    public function getCustomEmojies(): array
    {
        $result = $this->getRequest('/api/v1/realm/emoji');
        return array_map(
            fn($e) => CustomEmoji::from($e),
            (array)$result->emoji
        );
    }

    public function uploadCustomEmoji(string $path, string $name): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new FileAccessErrorException("File '{$path}' is not accessible");
        }
        $file = curl_file_create($path, mime_content_type($path));
        $name = urlencode($name);
        $this->postRequest("/api/v1/realm/emoji/{$name}", ['filename' => $file], jsonEncode: false);
    }

    public function getProfileCustomFields(): array
    {
        $result = $this->getRequest('/api/v1/realm/profile_fields');
        return array_map(
            fn($e) => CustomField::from($e),
            $result->custom_fields
        );
    }

    public function reorderProfileCustomField(array $order): void
    {
        $this->patchRequest('/api/v1/realm/profile_fields', ['order' => $order]);
    }

    public function createProfileCustomFields(CustomField $field): int
    {
        $result = $this->postRequest('/api/v1/realm/profile_fields', $field->jsonSerialize());
        return $result->id;
    }
}
