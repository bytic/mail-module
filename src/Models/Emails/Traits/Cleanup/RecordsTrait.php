<?php

namespace Nip\MailModule\Models\Emails\Traits\Cleanup;

use Nip\Config\Config;
use Nip\Database\Query\Update;

/**
 * Trait RecordsTrait
 * @package Nip\Mail\Models\Cleanup
 */
trait RecordsTrait
{
    protected static $sentDateField = 'date_sent';

    protected $daysToKeepData = 500;

    /**
     * @return \Nip\Database\Result
     */
    public function reduceOldEmailsData()
    {
        /** @var Update $query */
        $query = $this->newUpdateQuery();
        $query->where(
            '`' . $this::getSentDateField() . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL ' . $this->daysToKeepData . ' DAY)'
        );
        $query->data([
            'vars' => '',
            'body' => '',
            'compiled_subject' => '',
            'compiled_body' => '',
        ]);

        return $query->execute();
    }

    /**
     * @return string
     */
    public static function getSentDateField(): string
    {
        return self::$sentDateField;
    }

    /**
     * @param string $sentDateField
     */
    public static function setSentDateField(string $sentDateField)
    {
        self::$sentDateField = $sentDateField;
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
