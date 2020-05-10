<?php

namespace Nip\MailModule\Utility;

use Nip\MailModule\Console\Commands\EmailsCleanupData;
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
    public static function send()
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
    public static function cleanupRecords()
    {
        return (new EmailsCleanupData())->handle();
    }

    /**
     * @return int
     */
    public static function cleanupData()
    {
        return (new EmailsCleanupData())->handle();
    }
}
