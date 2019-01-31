<?php

namespace Nip\MailModule\Tests\Console\Commands;

use Mockery;
use Nip\MailModule\Console\Commands\EmailsSend;
use Nip\MailModule\Tests\AbstractTest;

/**
 * Class EmailsSendTest
 * @package Nip\MailModule\Tests\Console\Commands
 */
class EmailsSendTest extends AbstractTest
{
    public function testStoppingOnTwoInvalidBatches()
    {
        $command = Mockery::mock(EmailsSend::class)
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
