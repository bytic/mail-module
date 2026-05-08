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
     * Find an existing EmailContent record by body hash, or create a new one.
     */
    public function findOrCreateByBody(string $body): EmailContent
    {
        $hash = $this->hashBody($body);
        $existing = $this->findByHash($hash);
        if ($existing instanceof EmailContent) {
            return $existing;
        }

        /** @var EmailContent $content */
        $content = $this->getNew();
        $content->hash = $hash;
        $content->body = $body;
        $content->insert();

        return $content;
    }

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
