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
    public static function schedule(Scheduler $scheduler, $parameters = [], $bin = null)
    {
        self::scheduleSend($scheduler, $parameters, $bin);
        self::scheduleCleanupData($scheduler, $parameters, $bin);
        self::scheduleCleanupRecords($scheduler, $parameters, $bin);
    }

    public static function scheduleSend(Scheduler $scheduler, $parameters = [], $bin = null): void
    {
        $adder = $scheduler
            ->command(EmailsSend::NAME, $parameters, $bin)
            ->everyMinute();
        self::sheduleCommandConfig($adder, $parameters);
    }

    /**
     */
    public static function scheduleCleanupRecords(Scheduler $scheduler, $parameters = [], $bin = null)
    {
        $adder = $scheduler
            ->command(EmailsCleanupRecords::NAME, $parameters, $bin)
            ->setHour('1,2,3');
        self::sheduleCommandConfig($adder, $parameters);
    }

    /**
     */
    public static function scheduleCleanupData(Scheduler $scheduler, $parameters = [], $bin = null)
    {
        $adder = $scheduler
            ->command(EmailsCleanupData::NAME, $parameters, $bin)
            ->setHour('1,2,3');
        self::sheduleCommandConfig($adder, $parameters);
    }

    protected static function sheduleCommandConfig(EventAdder $adder, $config)
    {
        if (isset($config['using'])) {
            $adder->using($config['using']);
        }
    }
}
