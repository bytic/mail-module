<?php

declare(strict_types=1);

namespace Nip\MailModule;

use ByTIC\PackageBase\BaseBootableServiceProvider;

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
}
