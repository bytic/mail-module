<?php

namespace Nip\MailModule\Console\Commands;

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
        $result = $this->emailsManager()->reduceOldEmailsData();
        return $result->numRows();
    }
}
