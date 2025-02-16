<?php

declare(strict_types=1);

namespace Nip\MailModule\Utility;

use Bytic\Scheduler\Scheduler;
use Nip\MailModule\Console\Commands\EmailsCleanupData;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Console\Commands\EmailsSend;

/**
 * Class EmailCrons.
 */
class EmailScheduler
{
    public static function schedule(Scheduler $scheduler): int
    {
        self::scheduleSend($scheduler);
        self::scheduleCleanupData($scheduler);
        self::scheduleCleanupRecords($scheduler);
    }

    public static function scheduleSend(Scheduler $scheduler): void
    {
        $scheduler
            ->command(EmailsSend::NAME)
            ->everyMinute();
    }

    /**
     */
    public static function scheduleCleanupRecords(Scheduler $scheduler)
    {
        $scheduler
            ->command(EmailsCleanupRecords::NAME)
            ->setHour('1,2,3');
    }

    /**
     * @return mixed
     */
    public static function scheduleCleanupData(Scheduler $scheduler)
    {
        $scheduler
            ->command(EmailsCleanupData::NAME)
            ->setHour('1,2,3');
    }
}
