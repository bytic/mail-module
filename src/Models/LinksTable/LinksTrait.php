<?php

namespace Nip\MailModule\Models\LinksTable;

use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait LinksTrait
 * @package Nip\MailModule\Models\LinksTable
 */
trait LinksTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }
}
