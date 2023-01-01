<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailActivities;

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
}
