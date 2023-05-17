<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\Database\Result;
use Nip\MailModule\Emails\Actions\Cleanup\RemoveOldEmailData;

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
        $result = RemoveOldEmailData::run();
        if ($result->checkValid()) {
            return $result->numRows();
        }

        return 0;
    }
}
