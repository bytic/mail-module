<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailActivities;

use Nip\MailModule\Utility\MailModuleModels;
use Nip\MailModule\Utility\PackageConfig;
use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait ActivitiesTrait.
 */
trait EmailActivitiesTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }

    protected function generateTable(): string
    {
        return PackageConfig::tableName(MailModuleModels::ACTIVITIES, EmailActivities::TABLE);
    }
}
