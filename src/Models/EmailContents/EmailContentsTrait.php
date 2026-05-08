<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailContents;

use Nip\MailModule\Utility\MailModuleModels;
use Nip\MailModule\Utility\PackageConfig;

/**
 * Trait EmailContentsTrait.
 */
trait EmailContentsTrait
{
    /**
     * Find an EmailContent record by its body hash.
     */
    public function findByHash(string $hash): ?EmailContent
    {
        /** @var EmailContent|null $record */
        $record = $this->findOneByField('hash', $hash);

        return $record instanceof EmailContent ? $record : null;
    }

    /**
     * Compute a fast hash of the body string.
     */
    public function hashBody(string $body): string
    {
        return hash('xxh3', $body);
    }

    protected function generateTable(): string
    {
        return PackageConfig::tableName(MailModuleModels::EMAIL_CONTENTS, EmailContents::TABLE);
    }
}
