<?php

namespace Nip\MailModule\Tests\EmailsTable;

use Nip\Config\Config;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Swift_Message;

/**
 * Class EmailTraitTest
 * @package Nip\MailModule\Tests\EmailsTable
 */
class EmailTraitTest extends AbstractTest
{
    public function test_buildMailMessageFrom()
    {
        $email = new Email();
        $email->from = 'test@yahoo.com';
        $message = $email->newMailMessage();
        $email->buildMailMessageFrom($message);
        self::assertSame(['test@yahoo.com' => ''], $message->getFrom());
    }


    public function test_buildMailMessageFrom_empty()
    {

        /** @var Config $config */
        $config = app('config');
        $config->merge(new Config(['mail' => ['from' => ['address' => 'test@yahoo.com', 'name' => 'Test']]]));

        $email = new Email();
        $message = $email->newMailMessage();
        $email->buildMailMessageFrom($message);
        self::assertSame(['test@yahoo.com' => 'Test'], $message->getFrom());
    }

    public function test_buildMailMessageRecipients_replyTo_empty()
    {
        $email = new Email();
//        $email->reply_to = 'reply_to@mail.com';

        $message = $email->newMailMessage();
        $email->buildMailMessageRecipients($message);

        self::assertNull($message->getReplyTo());
    }

    public function test_buildMailMessageRecipients_replyTo_set()
    {
        $email = new Email();
        $email->reply_to = 'reply_to@mail.com';
        $email->from_name = 'My Name';

        $message = $email->newMailMessage();
        $email->buildMailMessageRecipients($message);

        self::assertSame(['reply_to@mail.com' => 'My Name'], $message->getReplyTo());
    }

    public function testBuildMailMessageAttachments()
    {
        $email = new Email();
        $email->id = 9;

        $message = $email->newMailMessage();
//        $email->buildMailMessageAttachments($message);

        self::assertInstanceOf(Swift_Message::class, $message);
    }
}
