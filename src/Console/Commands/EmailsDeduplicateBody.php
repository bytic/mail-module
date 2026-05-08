<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\MailModule\Emails\Actions\Cleanup\DeduplicateEmailBody;

/**
 * Console command that batch-processes existing email rows and moves their body
 * text into the shared email_contents table.
 *
 * Usage: emails:dedup-body [--batch=500]
 */
class EmailsDeduplicateBody extends EmailsAbstract
{
    public const NAME = 'emails:dedup-body';

    protected function configure(): void
    {
        parent::configure();
        $this->addOption('batch', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Number of emails to process per run', 500);
    }

    /**
     * @return int
     */
    public function handle()
    {
        $batchSize = (int) $this->option('batch');
        $batchSize = $batchSize > 0 ? $batchSize : 500;

        $emailsManager = $this->emailsManager();

        $query = $emailsManager->newQuery('select');
        $query->where('`body_id` IS NULL');
        $query->where('`body` != ""');
        $query->where('`body` IS NOT NULL');
        $query->limit($batchSize);

        $emails = $emailsManager->getByQuery($query);

        $processed = 0;
        foreach ($emails as $email) {
            if (DeduplicateEmailBody::run($email)) {
                ++$processed;
            }
        }

        return $processed;
    }
}
