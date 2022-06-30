<?php

namespace Rsa97\Zulip;

class User implements \JsonSerializable
{
    use Parseable;
    use Jsonable;

    #[Parseable('avatar_url')]
    public readonly string $avatarUrl;
    #[Parseable('avatar_version')]
    public readonly ?int $avatarVersion;
    #[Parseable('id')]
    #[Parseable('user_id')]
    public readonly int $id;
    #[Parseable('email', required: true)]
    #[Jsonable('email')]
    public readonly string $email;
    #[Parseable('full_name', required: true)]
    #[Jsonable('full_name')]
    public readonly string $fullName;
    #[Parseable('is_mirror_dummy')]
    public readonly bool $isMirrorDummy;
    #[Parseable('is_admin')]
    public readonly bool $isAdmin;
    #[Parseable('is_owner')]
    public readonly bool $isOwner;
    #[Parseable('is_billing_admin')]
    public readonly bool $isBillingAdmin;
    #[Parseable('is_guest')]
    public readonly bool $isGuest;
    #[Parseable('is_bot')]
    public readonly bool $isBot;
    #[Parseable('is_active')]
    public readonly bool $isActive;
    #[Parseable('bot_type', type: 'class', class: 'BotType')]
    public readonly BotType $botType;
    #[Parseable('bot_owner_id')]
    public readonly int $botOwnerId;
    #[Parseable('role', type: 'class', class: 'OrganizationRole')]
    public readonly OrganizationRole $role;
    #[Parseable('timezone', type: 'timezone')]
    public readonly \DateTimeZone $timezone;
    #[Parseable('date_joined', type: 'method', method: 'parseTimeString')]
    public readonly \DateTimeImmutable $dateJoined;
    #[Parseable('delivery_email')]
    public readonly string $deliveryEmail;
    #[Parseable('profile_data', type: 'method', method: 'parseUserProfile')]
    public readonly array $profileData;

    public function __construct(string $email, string $fullName) {
        $this->email = $email;
        $this->fullName = $fullName;
    }

    private static function parseTimeString(string $datetime): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d?H:i:s.ue', $datetime);
    }

    public static function parseUserProfile(object $profile): array
    {
        $data = (array)$profile;
        array_walk(
            $data,
            function (&$val, $key) {
                $val->id = $key;
                $val = UserProfileRecord::from($val);
            }
        );
        return $data;
    }
}
