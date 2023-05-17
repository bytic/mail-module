<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails\Traits\Cleanup;

use Nip\Config\Config;
use Nip\Database\Query\Update;
use Nip\MailModule\Emails\Actions\Cleanup\RemoveOldEmailData;

/**
 * Trait RecordsTrait.
 */
trait RecordsTrait
{
    protected static $sentDateField = 'date_sent';

    protected $daysToKeepData = 500;

    /**
     * @deprecated use RemoveOldEmailData::run()
     */
    public function reduceOldEmailsData()
    {
        return RemoveOldEmailData::run();
    }

    public static function getSentDateField(): string
    {
        return self::$sentDateField;
    }

    public static function setSentDateField(string $sentDateField)
    {
        self::$sentDateField = $sentDateField;
    }

    public function getDaysToKeepData(): int
    {
        return $this->daysToKeepData;
    }

    /**
     * @return float[]|int[]
     */
    public static function reduceEmailsByType(): array
    {
        $config = config('mail.cleanup.ttl');

        if ($config instanceof Config) {
            return $config->toArray();
        }

        return ['*' => 365 * 2];
    }
}
