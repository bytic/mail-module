<?php

namespace Nip\MailModule\Tests\Console\Commands;

use Mockery;
use Nip\Database\Adapters\MySQLi;
use Nip\Database\Connections\Connection;
use Nip\Database\Query\Delete;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailsCleanupRecordsTest
 * @package Nip\MailModule\Tests\Console\Commands
 */
class EmailsCleanupRecordsTest extends AbstractTest
{
    public function test_delete()
    {
        $query = null;

        $adapter = Mockery::mock(MySQLi::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $adapter->shouldReceive('cleanData')->andReturnArg(0);

        /** @var Connection|Mockery\Mock $database */
        $database = Mockery::mock(Connection::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $database->shouldReceive('execute')->with(\Mockery::capture($query))->once();
        $database->setAdapter($adapter);

        $emailsTable = new Emails();
        $emailsTable->setDB($database);
        ModelLocator::set('emails', $emailsTable);

        $command = new EmailsCleanupRecords();
        $command->handle();

        self::assertInstanceOf(Delete::class, $query);
        self::assertSame(
            'DELETE FROM `emails` WHERE `type` = \'donation\' AND `date_sent` <= DATE_SUB(CURRENT_DATE(), INTERVAL 365 DAY) LIMIT 500',
            $query->getString()
        );
    }
}
