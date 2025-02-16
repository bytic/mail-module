<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\Database\Query\Delete;
use Nip\Database\Result;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\Records\AbstractModels\RecordManager;

/**
 * Class EmailsCleanupRecords.
 */
class EmailsCleanupRecords extends EmailsAbstract
{
    public const NAME = 'emails:cleanup-records';

    /**
     * @return bool|int
     */
    public function handle()
    {
        $emailsManager = $this->emailsManager();

        $types = $emailsManager::reduceEmailsByType();
        $records = 0;
        foreach ($types as $type => $days) {
            $records += $this->deleteByType($emailsManager, $type, $days);
        }

        return $records;
    }

    /**
     * @param int $days
     *
     * @return bool|int
     */
    protected function deleteByType(RecordManager $emailsManager, string $type, $days)
    {
        $query = $this->deleteByTypeQuery($emailsManager, $type, $days);
        $result = $query->execute();
        if ($result instanceof Result && $result->isValid()) {
            return $result->numRows();
        }

        return 0;
    }

    /**
     * @param RecordManager $emailsManager
     * @param string        $type
     * @param int           $days
     *
     * @return Delete
     */
    protected function deleteByTypeQuery($emailsManager, $type, $days)
    {
        /** @var Emails $emailsManager */
        $query = $emailsManager->newDeleteQuery();
        if (\is_string($type) && \strlen($type) > 1) {
            $query->where('`type` = ?', $type);
        }
        $query->where(
            '`' . $emailsManager::getSentDateField() . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL ' . $days . ' DAY)'
        );

        $query->limit(500);

        return $query;
    }
}
