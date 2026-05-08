<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\EmailContents;

use Nip\MailModule\Models\EmailContents\EmailContentsTrait;
use Nip\MailModule\Tests\AbstractTest;

/**
 * Class EmailContentsTraitTest.
 */
class EmailContentsTraitTest extends AbstractTest
{
    public function test_hashBody_returns_consistent_hash(): void
    {
        $trait = $this->getObjectForTrait(EmailContentsTrait::class);

        $hash = $trait->hashBody('Hello World');

        self::assertNotEmpty($hash);
        self::assertSame($hash, $trait->hashBody('Hello World'));
    }

    public function test_hashBody_different_bodies_produce_different_hashes(): void
    {
        $trait = $this->getObjectForTrait(EmailContentsTrait::class);

        self::assertNotSame(
            $trait->hashBody('body one'),
            $trait->hashBody('body two')
        );
    }
}
