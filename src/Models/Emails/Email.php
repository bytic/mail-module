<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails;

use Nip\MailModule\Models\AbstractModels\CommonRecordTrait;

class Email extends \Nip\Records\Record
{
    use EmailTrait;
    use CommonRecordTrait;
}
