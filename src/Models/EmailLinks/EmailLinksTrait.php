<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailLinks;

use Nip\MailModule\Utility\MailModuleModels;
use Nip\MailModule\Utility\PackageConfig;
use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait LinksTrait.
 */
trait EmailLinksTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }

    protected function generateTable(): string
    {
        return PackageConfig::tableName(MailModuleModels::LINKS, EmailLinks::TABLE);
    }
}
