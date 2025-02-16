<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails\Status;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic;

abstract class AbstractStatus extends Generic
{
    public const NAME = null;

    protected function generateName(): string
    {
        return static::NAME;
    }
}