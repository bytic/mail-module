<?php

namespace Nip\MailModule\Models\EmailsTable\Traits\Cleanup;

use Nip\Database\Query\Update;

/**
 * Trait RecordsTrait
 * @package Nip\Mail\Models\Cleanup
 */
trait RecordsTrait
{
    protected $sentDateField = 'date_sent';
    protected $daysToKeepData = 365;

    /**
     * @return \Nip\Database\Result
     */
    public function reduceOldEmailsData()
    {
        /** @var Update $query */
        $query = $this->newUpdateQuery();
        $query->where(
            '`' . $this->sentDateField . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL ' . $this->daysToKeepData . ' DAY)'
        );
        $query->data([
            'vars' => '',
            'body' => '',
            'compiled_subject' => '',
            'compiled_body' => '',
        ]);

        return $query->execute();
    }
}
