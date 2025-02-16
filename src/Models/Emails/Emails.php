<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails;

use Nip\MailModule\Models\AbstractModels\CommonRecordsTrait;
use Nip\MailModule\Models\AbstractModels\HasDatabaseConnectionTrait;
use Nip\Records\RecordManager;

class Emails extends RecordManager
{
    public const TABLE = 'emails';

    use EmailsTrait;
    use CommonRecordsTrait;
    use HasDatabaseConnectionTrait;
}
