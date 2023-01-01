<?php

namespace Nip\MailModule\Utility;

use Exception;
use Nip\MailModule\MailModuleServiceProvider;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig.
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = MailModuleServiceProvider::NAME;

    public static function configPath(): string
    {
        return __DIR__ . '/../../config/mail-module.php';
    }
    /**
     * @throws Exception
     */
    public static function databaseConnection(): ?string
    {
        return (string)static::instance()->get('database.connection');
    }

}
