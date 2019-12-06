<?php

namespace Nip\MailModule\Tests\EmailsTable\Traits\MergeTags;

use Nip\MailModule\Tests\AbstractTest;
use Nip\MailModule\Tests\Fixtures\Models\Emails\Email;

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
}