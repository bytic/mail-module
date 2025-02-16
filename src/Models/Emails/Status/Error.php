<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails\Status;

/**
 *
 */
class Error extends AbstractStatus
{
    use Behaviours\IsImmutableTrait;

    public const NAME = 'issued';

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    public function getColorClass()
    {
        return 'primary';
    }

}