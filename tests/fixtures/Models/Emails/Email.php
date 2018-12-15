<?php

namespace Nip\MailModule\Tests\Fixtures\Models\Emails;

use Nip\MailModule\Models\EmailsTable\EmailTrait;
use Nip\Records\Record;

/**
 * Class Emails
 * @package Nip\MailModule\Tests\Fixtures\Models\Emails
 */
class Email extends Record
{
    use EmailTrait;
}
