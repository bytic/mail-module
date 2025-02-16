<?php

declare(strict_types=1);

namespace Nip\MailModule\Utility;

use Bytic\Scheduler\Events\EventAdder;
use Bytic\Scheduler\Scheduler;
use Nip\MailModule\Console\Commands\EmailsCleanupData;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Console\Commands\EmailsSend;

/**
 * Class EmailCrons.
 */
class EmailScheduler
{
    public static function schedule(Scheduler $scheduler, $config = []): void
    {
        self::scheduleSend($scheduler, $config);
        self::scheduleCleanupData($scheduler, $config);
        self::scheduleCleanupRecords($scheduler, $config);
    }

    public static function scheduleSend(Scheduler $scheduler, $config = []): void
    {
        $adder = $scheduler
            ->command(EmailsSend::NAME)
            ->everyMinute();
        self::sheduleCommandConfig($adder, $config);
    }

    /**
     */
    public static function scheduleCleanupRecords(Scheduler $scheduler, $config = [])
    {
        $adder = $scheduler
            ->command(EmailsCleanupRecords::NAME)
            ->setHour('1,2,3');
        self::sheduleCommandConfig($adder, $config);
    }

    /**
     */
    public static function scheduleCleanupData(Scheduler $scheduler, $config = [])
    {
        $adder = $scheduler
            ->command(EmailsCleanupData::NAME, $config = [])
            ->setHour('1,2,3');
        self::sheduleCommandConfig($adder, $config);
    }

    protected static function sheduleCommandConfig(EventAdder $adder, $config)
    {
        if (isset($config['using'])) {
            $adder->using($config['using']);
        }
    }
}
