<?php

namespace Rsa97\Zulip;

class UserSettings implements \JsonSerializable
{
    use Jsonable;

    #[Jsonable('full_name')]
    public readonly string $fullName;
    #[Jsonable('email')]
    public readonly string $email;
    #[Jsonable('old_password')]
    public readonly string $oldPassword;
    #[Jsonable('new_password')]
    public readonly string $newPassword;
    #[Jsonable('twenty_four_hour_time')]
    public readonly bool $twentyFourHourTime;
    #[Jsonable('dense_mode')]
    public readonly bool $denseMode;
    #[Jsonable('starred_message_counts')]
    public readonly bool $starredMessageCounts;
    #[Jsonable('fluid_layout_width')]
    public readonly bool $fluidLayoutWidth;
    #[Jsonable('high_contrast_mode')]
    public readonly bool $highContrastMode;
    #[Jsonable('color_scheme')]
    public readonly ColorScheme $colorScheme;
    #[Jsonable('enable_drafts_synchronization')]
    public readonly bool $draftsSynchronization;
    #[Jsonable('translate_emoticons')]
    public readonly bool $translateEmoticons;
    #[Jsonable('display_emoji_reaction_users')]
    public readonly bool $displayEmojiReactionUsers;
    #[Jsonable('default_language')]
    public readonly string $defaultLanguage;
    #[Jsonable('default_view')]
    public readonly View $defaultView;
    #[Jsonable('escape_navigates_to_default_view')]
    public readonly bool $escapeNavigateToDefaultView;
    #[Jsonable('left_side_userlist')]
    public readonly bool $leftSideUserlist;
    #[Jsonable('emojiset', type: 'enum')]
    public readonly EmojiSet $emojiSet;
    #[Jsonable('demote_inactive_streams', type: 'enum')]
    public readonly DemotionMode $demoteInctiveStreams;
    #[Jsonable('timezone', type: 'timezone')]
    public readonly \DateTimeZone $timezone;
    #[Jsonable('enable_stream_desktop_notifications')]
    public readonly bool $streamDesktopNotifications;
    #[Jsonable('enable_stream_email_notifications')]
    public readonly bool $streamEmailNotifications;
    #[Jsonable('enable_stream_push_notifications')]
    public readonly bool $streamPushNotifications;
    #[Jsonable('enable_stream_audible_notifications')]
    public readonly bool $streamAudibleNotifications;
    #[Jsonable('notification_sound')]
    public readonly string $notificationSound;
    #[Jsonable('enable_desktop_notifications')]
    public readonly bool $desktopNotifications;
    #[Jsonable('enable_sounds')]
    public readonly bool $sounds;
    #[Jsonable('email_notifications_batching_period_seconds')]
    public readonly int $emailNotificationBatchingPeriodSeconds;
    #[Jsonable('enable_offline_email_notifications')]
    public readonly bool $offlineEmailNotifications;
    #[Jsonable('enable_offline_push_notifications')]
    public readonly bool $offlinePushNotifications;
    #[Jsonable('enable_online_push_notifications')]
    public readonly bool $onlinePushNoptifications;
    #[Jsonable('enable_digest_emails')]
    public readonly bool $digestEmails;
    #[Jsonable('enable_marketing_emails')]
    public readonly bool $marketingEmails;
    #[Jsonable('enable_login_emails')]
    public readonly bool $loginEmails;
    #[Jsonable('message_content_in_email_notifications')]
    public readonly bool $streamContentInEmailNotifications;
    #[Jsonable('pm_content_in_desktop_notifications')]
    public readonly bool $privateContentInEmailNotifications;
    #[Jsonable('wildcard_mentions_notify')]
    public readonly bool $wildcardMentionsNotify;
    #[Jsonable('desktop_icon_count_display', type: 'enum')]
    public readonly CountDisplayMode $desktopIconCountDisplay;
    #[Jsonable('realm_name_in_notifications')]
    public readonly bool $realmNameInNotifications;
    #[Jsonable('presence_enabled')]
    public readonly bool $displayPresence;
    #[Jsonable('enter_sends')]
    public readonly bool $enterSends;
    #[Jsonable('send_private_typing_notifications')]
    public readonly bool $sendPrivateTypingNotifications;
    #[Jsonable('send_stream_typing_notifications')]
    public readonly bool $sendStreamTypingNotifications;
    #[Jsonable('send_read_receipts')]
    public readonly bool $sendReadReceipt;

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function changePassword(string $oldPassword, string $newPassword): self
    {
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        return $this;
    }

    public function setTwentyFourHourTime(bool $enable): self
    {
        $this->twentyFourHourTime = $enable;
        return $this;
    }

    public function setDenseMode(bool $enable): self
    {
        $this->denseMode = $enable;
        return $this;
    }

    public function setStarredMessageCounts(bool $enable): self
    {
        $this->starredMessageCounts = $enable;
        return $this;
    }

    public function setFluidLayoutWidth(bool $enable): self
    {
        $this->fluidLayoutWidth = $enable;
        return $this;
    }

    public function setHighContrastMode(bool $isHighContrastMode): self
    {
        $this->isHighContrastMode = $isHighContrastMode;
        return $this;
    }

    public function setColorScheme(ColorScheme $scheme): self
    {
        $this->colorScheme = $scheme;
        return $this;
    }

    public function setDraftsSynchronization(bool $enable): self
    {
        $this->draftsSynchronization = $enable;
        return $this;
    }

    public function setTranslateEmoticons(bool $enable): self
    {
        $this->translateEmoticons = $enable;
        return $this;
    }

    public function setDisplayEmojiReactionUser(bool $enable): self
    {
        $this->displayEmojiReactionUsers = $enable;
        return $this;
    }

    public function setDefaultLanguage(string $language): self
    {
        $this->defaultLanguage = $language;
        return $this;
    }

    public function setDefaultView(View $view): self
    {
        $this->defaultView = $view;
        return $this;
    }

    public function setEcsapeNavigateToDefaultView(bool $enable): self
    {
        $this->escapeNavigateToDefaultView = $enable;
        return $this;
    }

    public function setLeftSideUserlist(bool $enable): self
    {
        $this->leftSideUserlist = $enable;
        return $this;
    }

    public function setEmojiSet(EmojiSet $emojiSet): self
    {
        $this->emojiSet = $emojiSet;
        return $this;
    }

    public function setDemoteInactiveStreams(DemotionMode $mode): self
    {
        $this->demoteInctiveStreams = $mode;
        return $this;
    }

    public function setTimezone(\DateTimeZone $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function setStreamDesktopNotifications(bool $enable): self
    {
        $this->streamDesktopNotifications = $enable;
        return $this;
    }

    public function setStreamEmailNotifications(bool $enable): self
    {
        $this->streamEmailNotifications = $enable;
        return $this;
    }

    public function setStreamPushNotifications(bool $enable): self
    {
        $this->streamPushNotifications = $enable;
        return $this;
    }

    public function setStreamAudibleNotifications(bool $enable): self
    {
        $this->streamAudibleNotifications = $enable;
        return $this;
    }

    public function setNotificationSound(string $sound): self
    {
        $this->notificationSound = $sound;
        return $this;
    }

    public function setDesktopNotifications(bool $enable): self
    {
        $this->desktopNotifications = $enable;
        return $this;
    }

    public function setSounds(bool $enable): self
    {
        $this->sounds = $enable;
        return $this;
    }

    public function setEmailNotificationBatchingPeriodSeconds(int $period): self
    {
        $this->emailNotificationBatchingPeriodSeconds = $period;
        return $this;
    }

    public function setOfflineEmailNotifications(bool $enable): self
    {
        $this->offlineEmailNotifications = $enable;
        return $this;
    }

    public function setOfflinePushNotifications(bool $enable): self
    {
        $this->offlinePushNotifications = $enable;
        return $this;
    }   

    public function setOnlinePushNotifications(bool $enable): self
    {
        $this->onlinePushNotifications = $enable;
        return $this;
    }

    public function setDigestEmails(bool $enable): self
    {
        $this->digestEmails = $enable;
        return $this;
    }

    public function setMarketingEmails(bool $enable): self
    {
        $this->marketingEmails = $enable;
        return $this;
    }

    public function setLoginEmails(bool $enable): self
    {
        $this->loginEmails = $enable;
        return $this;
    }

    public function setStreamContentInEmailNotifications(bool $enable): self
    {
        $this->streamContentInEmailNotifications = $enable;
        return $this;
    }

    public function setPrivateContentInEmailNotifications(bool $enable): self
    {
        $this->privateContentInEmailNotifications = $enable;
        return $this;
    }

    public function setWildcardMentionsNotify(bool $enable): self
    {
        $this->wildcardMentionsNotify = $enable;
        return $this;
    }

    public function setDesktopIconCounntDisplay(CountDisplayMode $mode): self
    {
        $this->setDesktopIconCounntDisplay = $mode;
        return $this;
    }

    public function setRealmNameInNotifications(bool $enable): self
    {
        $this->realmNameInNotifications = $enable;
        return $this;
    }

    public function setDisplayPresence(bool $enable): self
    {
        $this->displayPresence = $enable;
        return $this;
    }

    public function setEnterSends(bool $enable): self
    {
        $this->enterSends = $enable;
        return $this;
    }

    public function setSendStreamTypingNotifications(bool $enable): self
    {
        $this->sendStreamTypingNotifications = $enable;
        return $this;
    }

    public function setPrivateStreamTypingNotifications(bool $enable): self
    {
        $this->sendPrivateTypingNotifications = $enable;
        return $this;
    }

    public function setSendReadReceipt(bool $enable): self
    {
        $this->sendReadReceipt = $enable;
        return $this;
    }
}
