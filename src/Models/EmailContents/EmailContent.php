<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailContents;

use Nip\MailModule\Models\AbstractModels\CommonRecordTrait;

class EmailContent extends \Nip\Records\Record
{
    use EmailContentTrait;
    use CommonRecordTrait;
}
