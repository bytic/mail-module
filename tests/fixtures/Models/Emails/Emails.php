<?php

namespace Nip\MailModule\Tests\Fixtures\Models\Emails;

use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\RecordManager;

/**
 * Class Emails
 * @package Nip\MailModule\Tests\Fixtures\Models\Emails
 */
class Emails extends RecordManager
{
    use EmailsTrait;

    /**
     * @return string
     */
    public function generateTable()
    {
        return 'emails';
    }
}
