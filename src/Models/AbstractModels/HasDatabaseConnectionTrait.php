<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\AbstractModels;

use Nip\Database\Connections\Connection;
use Nip\MailModule\Utility\PackageConfig;

/**
 * Trait HasDatabaseConnectionTrait.
 */
trait HasDatabaseConnectionTrait
{
    /**
     * @return Connection
     */
    protected function newDbConnection()
    {
        return app('db')->connection(PackageConfig::databaseConnection());
    }
}
