<?php

namespace Nip\MailModule\Models\ActivitiesTable;

use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait ActivitiesTrait
 * @package Nip\Mail\Models\ActivitiesTable
 */
trait ActivitiesTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }
}
