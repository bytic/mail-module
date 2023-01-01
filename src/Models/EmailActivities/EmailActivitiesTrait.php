<?php

namespace Nip\MailModule\Models\EmailActivities;

use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait ActivitiesTrait
 * @package Nip\Mail\Models\ActivitiesTable
 */
trait EmailActivitiesTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }
}
