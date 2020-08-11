<?php

namespace Nip\MailModule\Tests\EmailsTable\Traits\MergeTags;

use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;

use Mockery as m;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Emails;

/**
 * Class MergeTagsRecordTraitTest
 * @package Nip\MailModule\Tests\EmailsTable\Traits\MergeTags
 */
class MergeTagsRecordTraitTest extends AbstractTest
{
    public function test_setVars()
    {
        $email = new Email();
        $email->setVars([1 => 2]);

        self::assertSame([1 => 2], $email->getMergeTags());
    }

    public function test_saveMergeTagsToDbField()
    {
        $email = new Email();
        $emails = m::mock(Emails::class)->makePartial();
        $emails->shouldReceive('insert');
        $emails->shouldReceive('getPrimaryKey');
        $email->setManager($emails);

        $email->setVars([1 => 2]);
        $email->insert();

        self::assertSame('{"1":2}', $email->vars);
    }
}
