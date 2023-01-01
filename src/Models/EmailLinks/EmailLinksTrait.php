<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailLinks;

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
}
