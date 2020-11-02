<?php

namespace Nip\MailModule\Utility;

use Nip\MailModule\Console\Commands\EmailsCleanupData;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Console\Commands\EmailsSend;

/**
 * Class EmailCrons
 * @package Nip\MailModule\Utility
 */
class EmailCrons
{
    /**
     * @return int
     */
    public static function send(): int
    {
        return (new EmailsSend())->handle();
    }

    public static function cleanup()
    {
        static::cleanupData();
        static::cleanupRecords();
    }

    /**
     * @return int
     */
    public static function cleanupRecords(): int
    {
        return (new EmailsCleanupData())->handle();
    }

    /**
     * @return int
     */
    public static function cleanupData(): int
    {
        return (new EmailsCleanupRecords())->handle();
    }
}
