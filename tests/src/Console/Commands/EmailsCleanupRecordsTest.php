<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\Console\Commands;

use Mockery;
use Nip\Database\Adapters\MySQLi;
use Nip\Database\Connections\Connection;
use Nip\Database\Query\Delete;
use Nip\MailModule\Console\Commands\EmailsCleanupRecords;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;
use Nip\MailModule\Utility\MailModuleModels;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailsCleanupRecordsTest.
 */
class EmailsCleanupRecordsTest extends AbstractTest
{
    public function testDelete()
    {
        $query = null;

        $adapter = \Mockery::mock(MySQLi::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $adapter->shouldReceive('cleanData')->andReturnArg(0);

        /** @var Connection|Mockery\Mock $database */
        $database = \Mockery::mock(Connection::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $database->shouldReceive('execute')->with(\Mockery::capture($query))->once();
        $database->setAdapter($adapter);

        $emailsTable = new Emails();
        $emailsTable->setDB($database);
        MailModuleModels::emails()->setDB($database);

        $command = new EmailsCleanupRecords();
        $command->handle();

        self::assertInstanceOf(Delete::class, $query);
        self::assertSame(
            'DELETE FROM `emails` WHERE `type` = \'donation\' AND `date_sent` <= DATE_SUB(CURRENT_DATE(), INTERVAL 365 DAY) LIMIT 500',
            $query->getString()
        );
    }
}
