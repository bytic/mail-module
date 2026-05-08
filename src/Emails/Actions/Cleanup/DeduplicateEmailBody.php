<?php

declare(strict_types=1);

namespace Nip\MailModule\Emails\Actions\Cleanup;

use Bytic\Actions\Action;
use Nip\MailModule\Models\EmailContents\EmailContent;
use Nip\MailModule\Models\Emails\EmailTrait;
use Nip\MailModule\Utility\MailModuleModels;
use Nip\Records\AbstractModels\Record;

/**
 * Deduplicates the body of a single email record.
 *
 * Flow:
 *  1. If the email already has a body_id, nothing to do.
 *  2. Hash the body, find-or-create an EmailContent record.
 *  3. Update the email row: set body_id and clear the body column.
 */
class DeduplicateEmailBody extends Action
{
    /** @var Record|EmailTrait */
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle(): bool
    {
        $email = $this->email;

        if (!empty($email->body_id)) {
            return false;
        }

        $body = $email->body;
        if (empty($body)) {
            return false;
        }

        $contentsManager = MailModuleModels::emailContents();
        /** @var EmailContent $content */
        $content = $contentsManager->findOrCreateByBody($body);

        $email->body_id = $content->id;
        $email->body = '';
        $email->update();

        return true;
    }
}
