<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use ByTIC\Console\Command;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\MailModule\Utility\MailModuleModels;

/**
 * Class EmailsAbstract.
 */
abstract class EmailsAbstract extends Command
{

    protected function configure(): void
    {
        parent::configure();
        if (defined('static::NAME')) {
            $this->setName(static::NAME);
        }
    }

    abstract public function handle();

    /**
     * @return Emails
     */
    protected function emailsManager()
    {
        /* @phpstan-ignore-next-line */
        return MailModuleModels::emails();
    }
}
