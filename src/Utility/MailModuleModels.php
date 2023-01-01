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
    protected static array $models = [];

    /**
     * @return RecordManager|Emails
     */
    public static function emails()
    {
        return static::getModels('emails', Emails::class);
    }

    /**
     * @return RecordManager|EmailActivities
     */
    public static function activities()
    {
        return static::getModels('activities', EmailActivities::class);
    }

    /**
     * @return RecordManager|EmailLinks
     */
    public static function links()
    {
        return static::getModels('links', EmailLinks::class);
    }

    protected static function packageName(): string
    {
        return MailModuleServiceProvider::NAME;
    }
}
