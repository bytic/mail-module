<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\Console\Commands;

use Nip\MailModule\Console\Commands\EmailsSend;
use Nip\MailModule\Tests\AbstractTest;

/**
 * Class EmailsSendTest.
 */
class EmailsSendTest extends AbstractTest
{
    public function testStoppingOnTwoInvalidBatches()
    {
        $command = \Mockery::mock(EmailsSend::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $command->shouldReceive('sendEmails')
            ->andReturn(0, 4, false);

        $command->shouldReceive('getEmailsBatch')->with(10, 0)->andReturn([]);
        $command->shouldReceive('getEmailsBatch')->with(10, 10)->andReturn([]);
        $command->shouldReceive('getEmailsBatch')->with(10, 20)->andReturn([]);

//        $this->expectOutputString('as');
        self::assertSame(4, $command->handle());
    }
}
