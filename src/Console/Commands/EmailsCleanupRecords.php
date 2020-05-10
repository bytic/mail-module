<?php

namespace Nip\MailModule\Console\Commands;

use Nip\Database\Query\Delete;
use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Class EmailsCleanupRecords
 * @package Nip\MailModule\Console\Commands
 */
class EmailsCleanupRecords
{


    public function handle()
    {
        /** @var EmailsTrait $emailsManager */
        $emailsManager = ModelLocator::get('emails');

        $types = $emailsManager::reduceEmailsByType();
        foreach ($types as $type => $days) {
            $this->deleteByType($emailsManager, $type, $days);
        }
    }

    /**
     * @param EmailsTrait|RecordManager $emailsManager
     * @param $type
     * @param $days
     */
    protected function deleteByType(RecordManager $emailsManager, string $type, $days)
    {
        $query = $this->deleteByTypeQuery($emailsManager, $type, $days);
        $query->execute();
    }

    /**
     * @param EmailsTrait|RecordManager $emailsManager
     * @param $type
     * @param $days
     * @return Delete
     */
    protected function deleteByTypeQuery($emailsManager, $type, $days)
    {
        $query = $emailsManager->newDeleteQuery();
        if (is_string($type) && strlen($type) > 1) {
            $query->where('`type` = ?', $type);
        }
        $query->where(
            '`' . $emailsManager::getSentDateField() . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL ' . $days . ' DAY)'
        );

        $query->limit(500);

        return $query;
    }
}
