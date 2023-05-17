<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\MailModule\Utility\MailModuleModels;

/**
 * Class EmailsAbstract.
 */
abstract class EmailsAbstract
{
    /**
     * @return Emails
     */
    protected function emailsManager()
    {
        /* @phpstan-ignore-next-line */
        return MailModuleModels::emails();
    }
}
