<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\Database\Result;

/**
 * Class EmailsCleanupData.
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
