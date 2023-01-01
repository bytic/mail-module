<?php

declare(strict_types=1);

namespace Nip\MailModule\Utility;

use Nip\MailModule\Console\Commands\EmailsCleanupData;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Console\Commands\EmailsSend;

/**
 * Class EmailCrons.
 */
class EmailCrons
{
    public static function send(): int
    {
        return (new EmailsSend())->handle();
    }

    public static function cleanup(): void
    {
        static::cleanupData();
        static::cleanupRecords();
    }

    /**
     * @return mixed
     */
    public static function cleanupRecords()
    {
        return (new EmailsCleanupData())->handle();
    }

    /**
     * @return mixed
     */
    public static function cleanupData()
    {
        return (new EmailsCleanupRecords())->handle();
    }
}
