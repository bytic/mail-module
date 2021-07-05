<?php

namespace Nip\MailModule\Console\Commands;

use Nip\Database\Result;

/**
 * Class EmailsCleanupData
 * @package Nip\MailModule\Console\Commands
 */
class EmailsCleanupData extends EmailsAbstract
{
    /**
     * @return int|bool
     */
    public function handle()
    {
        /** @var Result $result */
        $result = $this->emailsManager()->reduceOldEmailsData();
        if ($result->checkValid()) {
            return $result->numRows();
        }
        return 0;
    }
}
