<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailLinks;

use Nip\MailModule\Models\AbstractModels\CommonRecordsTrait;
use Nip\MailModule\Models\AbstractModels\HasDatabaseConnectionTrait;

class EmailLinks extends \Nip\Records\RecordManager
{
    use EmailLinksTrait;
    use CommonRecordsTrait;
    use HasDatabaseConnectionTrait;
}
