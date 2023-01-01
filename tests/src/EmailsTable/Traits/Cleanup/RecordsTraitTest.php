<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\EmailsTable\Traits\Cleanup;

use Nip\Database\Adapters\MySQLi;
use Nip\Database\Connections\Connection;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;

/**
 * Class RecordsTraitTest.
 */
class RecordsTraitTest extends AbstractTest
{
    public function testReduceOldEmailsData()
    {
        $adapter = \Mockery::mock(MySQLi::class)->makePartial();
        $adapter->shouldReceive('cleanData')
            ->andReturnUsing(function ($data) {
                return $data;
            });

        $database = \Mockery::mock(Connection::class)->makePartial();
        $database->shouldReceive('execute')
            ->andReturnUsing(function ($query) {
                return $query->getString();
            });
        $database->setAdapter($adapter);

        $emails = new Emails();
        $emails->setDB($database);

        $query = $emails->reduceOldEmailsData();

        self::assertSame(
            'UPDATE `emails` '
            . 'SET `vars` = \'\', `body` = \'\', `compiled_subject` = \'\', `compiled_body` = \'\' '
            . 'WHERE `date_sent` <= DATE_SUB(CURRENT_DATE(), INTERVAL 500 DAY)',
            $query
        );
    }

    public function testReduceEmailsByType()
    {
        $emails = new Emails();
        $types = $emails::reduceEmailsByType();

        self::assertSame(['*' => 365, 'donation' => 365], $types);
    }
}
