<?php

namespace Nip\MailModule\Models\EmailsTable\Traits\Cleanup;

use Nip\Database\Query\Update;

/**
 * Trait RecordsTrait
 * @package Nip\Mail\Models\Cleanup
 */
trait RecordsTrait
{
    protected static $sentDateField = 'date_sent';

    protected $daysToKeepData = 365;

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
    public static function reduceEmailsByType()
    {
        if (method_exists()) {
            $types[            '*'] = 365 * 2;
        }
        return $types;
    }
}
