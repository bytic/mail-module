<?php

namespace Nip\MailModule\Console\Commands;

use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailsAbstract
 * @package Nip\MailModule\Console\Commands
 */
abstract class EmailsAbstract
{
    /**
     * @return Emails
     */
    protected function emailsManager()
    {
        /** @phpstan-ignore-next-line */
        return ModelLocator::get('emails');
    }
}