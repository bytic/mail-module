<?php

declare(strict_types=1);

namespace Nip\MailModule\Utility;

use Exception;
use Nip\Config\Config;
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
     * @param $name
     * @param $default
     * @return mixed|Config|string|null
     * @throws Exception
     */
    public static function tableName($name, $default = null)
    {
        return static::instance()->get('tables.' . $name, $default);
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function databaseConnection(): ?string
    {
        return (string) static::instance()->get('database.connection');
    }

    public static function shouldRunMigrations(): bool
    {
        return static::instance()->get('database.migrations', false) !== false;
    }
}
