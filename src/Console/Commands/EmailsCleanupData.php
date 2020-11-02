<?php

namespace Nip\MailModule\Console\Commands;

use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailsCleanupData
 * @package Nip\MailModule\Console\Commands
 */
class EmailsCleanupData
{
    /**
     * @return int
     */
    public function handle()
    {
        /** @var EmailsTrait $emailsManager */
        $emailsManager = ModelLocator::get('emails');
        $result = $emailsManager->reduceOldEmailsData();
        return $result->numRows();
    }
}
