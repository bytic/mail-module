<?php

namespace Nip\MailModule\Models\EmailLinks;

use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait LinksTrait
 * @package Nip\MailModule\Models\LinksTable
 */
trait EmailLinksTrait
{
    use RecordsTrait;

    protected function initRelations()
    {
        $this->belongsTo('Email');
    }
}
