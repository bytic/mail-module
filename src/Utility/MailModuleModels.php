<?php

declare(strict_types=1);

namespace Nip\MailModule\Utility;

use ByTIC\PackageBase\Utility\ModelFinder;
use Nip\MailModule\MailModuleServiceProvider;
use Nip\MailModule\Models\EmailActivities\EmailActivities;
use Nip\MailModule\Models\EmailLinks\EmailLinks;
use Nip\MailModule\Models\Emails\Emails;
use Nip\Records\RecordManager;

/**
 * Class NotifierBuilderModels.
 */
class MailModuleModels extends ModelFinder
{
    public const EMAILS = 'emails';
    public const ACTIVITIES = 'activities';
    public const LINKS = 'links';

    protected static array $models = [];

    /**
     * @return RecordManager|Emails
     */
    public static function emails()
    {
        return static::getModels(self::EMAILS, Emails::class);
    }

    public static function emailsTable(): string
    {
        return static::getTable(self::EMAILS, Emails::TABLE);
    }

    /**
     * @return RecordManager|EmailActivities
     */
    public static function activities()
    {
        return static::getModels(self::ACTIVITIES, EmailActivities::class);
    }


    public static function activitiesTable(): string
    {
        return static::getTable(self::ACTIVITIES, EmailActivities::TABLE);
    }

    /**
     * @return RecordManager|EmailLinks
     */
    public static function links()
    {
        return static::getModels(self::LINKS, EmailLinks::class);
    }

    public static function linksTable(): string
    {
        return static::getTable(self::LINKS, EmailLinks::TABLE);
    }

    protected static function packageName(): string
    {
        return MailModuleServiceProvider::NAME;
    }
}
