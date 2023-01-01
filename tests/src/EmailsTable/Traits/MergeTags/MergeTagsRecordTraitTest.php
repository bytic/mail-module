<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\EmailsTable\Traits\MergeTags;

use Mockery as m;
use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;

/**
 * Class MergeTagsRecordTraitTest.
 */
class MergeTagsRecordTraitTest extends AbstractTest
{
    /**
     * @return void
     */
    public function testSetVars()
    {
        $email = new Email();
        $email->setVars([1 => 2]);

        self::assertSame([1 => 2], $email->getMergeTags());
    }

    /**
     * @return void
     */
    public function testSaveMergeTagsToDbField()
    {
        $email = new Email();
        /** @var m\Mock|Emails $emails */
        $emails = m::mock(Emails::class)->makePartial();
        $emails->setFields(['vars']);
        $emails->shouldReceive('insert');
        $emails->shouldReceive('getPrimaryKey');
        $email->setManager($emails);

        $email->setVars([1 => 2]);
        self::assertSame([1 => 2], $email->vars);

        $data = $emails->getQueryModelData($email);
        self::assertSame('{"1":2}', $data['vars']);
    }
}
