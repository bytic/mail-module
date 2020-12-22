<?php

namespace Nip\MailModule\Tests\EmailsTable;

use Mockery\Mock;
use Nip\Database\Query\Insert;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;

/**
 * Class EmailsTraitTest
 * @package Nip\MailModule\Tests\EmailsTable
 */
class EmailsTraitTest extends AbstractTest
{
    public function test_sent_no_on_insert()
    {
        $email = new Email();

        /** @var Emails|Mock $emails */
        $emails = \Mockery::mock(Emails::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $emails->shouldReceive('insertQuery')->andReturn(new Insert());
        $emails->shouldReceive('performInsert')->andReturn(true);

        $emails->bootEmailsTrait();

        $emails->insert($email);
        self::assertSame('no', $email->get('sent'));
    }
}