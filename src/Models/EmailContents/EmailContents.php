<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailContents;

use Nip\MailModule\Models\AbstractModels\CommonRecordsTrait;
use Nip\MailModule\Models\AbstractModels\HasDatabaseConnectionTrait;
use Nip\Records\RecordManager;

class EmailContents extends RecordManager
{
    public const TABLE = 'email-contents';

    use EmailContentsTrait;
    use CommonRecordsTrait;
    use HasDatabaseConnectionTrait;
}
