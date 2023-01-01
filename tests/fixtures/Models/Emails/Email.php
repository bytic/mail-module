<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\Fixtures\Models\Emails;

use Nip\MailModule\Models\EmailsTable\EmailTrait;
use Nip\Records\Record;

/**
 * Class Emails.
 */
class Email extends Record
{
    use EmailTrait;
}
