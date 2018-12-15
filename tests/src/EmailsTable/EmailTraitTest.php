<?php

namespace Nip\MailModule\Tests\EmailsTable;

use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Swift_Message;

/**
 * Class EmailTraitTest
 * @package Nip\MailModule\Tests\EmailsTable
 */
class EmailTraitTest extends AbstractTest
{
    public function testBuildMailMessageAttachments()
    {
        $email = new Email();
        $email->id = 9;

        $message = $email->newMailMessage();
//        $email->buildMailMessageAttachments($message);

        self::assertInstanceOf(Swift_Message::class, $message);
    }
}
