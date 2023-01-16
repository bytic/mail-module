<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailActivities;

use Nip\MailModule\Models\AbstractModels\CommonRecordsTrait;
use Nip\MailModule\Models\AbstractModels\HasDatabaseConnectionTrait;

class EmailActivities extends \Nip\Records\RecordManager
{
    use EmailActivitiesTrait;
    use CommonRecordsTrait;
    use HasDatabaseConnectionTrait;
}
