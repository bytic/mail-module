<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailLinks;

use Nip\MailModule\Models\AbstractModels\CommonRecordTrait;

class EmailLink extends \Nip\Records\Record
{
    use EmailLinkTrait;
    use CommonRecordTrait;
}
