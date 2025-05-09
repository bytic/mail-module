<?php

declare(strict_types=1);

namespace Nip\MailModule;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use Nip\MailModule\Console\Commands\EmailsCleanupData;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Console\Commands\EmailsSend;
use Nip\MailModule\Utility\PackageConfig;

/**
 * Class NotifierBuilderProvider.
 */
class MailModuleServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'mail-module';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        parent::register();
        $this->addRepositoryNamespace('Nip\MailModule\Models');
    }

    public function migrations(): ?string
    {
        if (PackageConfig::shouldRunMigrations()) {
            return dirname(__DIR__) . '/migrations/';
        }

        return null;
    }

    protected function registerCommands(): void
    {
        $this->commands(
            EmailsSend::class,
            EmailsCleanupRecords::class,
            EmailsCleanupData::class,
        );
    }
}
