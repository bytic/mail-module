<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\EmailsTable;

use Mockery\Mock;
use Nip\Database\Query\Insert;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;

/**
 * Class EmailsTraitTest.
 */
class EmailsTraitTest extends AbstractTest
{
    public function testSentNoOnInsert()
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
