<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailActivities;

use Nip\MailModule\Models\AbstractModels\CommonRecordTrait;

class EmailActivity extends \Nip\Records\Record
{
    use EmailActivityTrait;
    use CommonRecordTrait;
}
