<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\EmailsTable;

use Nip\Config\Config;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;

/**
 * Class EmailTraitTest.
 */
class EmailTraitTest extends AbstractTest
{

    public function test_getSubject()
    {
        $email = new Email();
        $email->subject = 'Mulțumim pentru &icirc;nscrierea ta {{entry.race.name}} la {{entry.event.name}}!';

        self::assertEquals(
            'Mulțumim pentru înscrierea ta {{entry.race.name}} la {{entry.event.name}}!',
            $email->getSubject()
        );
    }

    public function testBuildMailMessageFrom()
    {
        $email = new Email();
        $email->from = 'test@yahoo.com';
        $message = $email->newMailMessage();
        $email->buildMailMessageFrom($message);
        self::assertEquals([Address::create('test@yahoo.com')], $message->getFrom());
    }

    public function testBuildMailMessageFromEmpty()
    {
        /** @var Config $config */
        $config = app('config');
        $config->merge(new Config(['mail' => ['from' => ['address' => 'test@yahoo.com', 'name' => 'Test']]]));

        $email = new Email();
        $message = $email->newMailMessage();
        $email->buildMailMessageFrom($message);
        self::assertEquals([Address::create('Test <test@yahoo.com>')], $message->getFrom());
    }

    public function testBuildMailMessageRecipientsReplyToEmpty()
    {
        $email = new Email();
//        $email->reply_to = 'reply_to@mail.com';

        $message = $email->newMailMessage();
        $email->buildMailMessageRecipients($message);

        self::assertEmpty($message->getReplyTo());
    }

    public function testBuildMailMessageRecipientsReplyToSet()
    {
        $email = new Email();
        $email->reply_to = 'reply_to@mail.com';
        $email->from_name = 'My Name';
        $email->from = 'noreply@test.com';

        $message = $email->newMailMessage();
        $email->buildMailMessageRecipients($message);

        self::assertEquals([Address::create('My Name <reply_to@mail.com>')], $message->getReplyTo());
    }

    public function testBuildMailMessageAttachments()
    {
        $email = new Email();
        $email->id = 9;

        $message = $email->newMailMessage();
//        $email->buildMailMessageAttachments($message);

        self::assertInstanceOf(Message::class, $message);
    }
}
