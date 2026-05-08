<?php

declare(strict_types=1);

namespace Nip\MailModule\EmailContents\Actions;

use Bytic\Actions\Action;
use Nip\MailModule\Models\EmailContents\EmailContent;
use Nip\MailModule\Models\EmailContents\EmailContents;
use Nip\MailModule\Utility\MailModuleModels;

class FindOrCreateByBody extends Action
{
    protected string $body;

    public static function forBody(string $body): static
    {
        $action = new static();
        $action->body = $body;

        return $action;
    }

    public function handle(): EmailContent
    {
        $manager = $this->manager();
        $hash = $manager->hashBody($this->body);
        $existing = $manager->findByHash($hash);
        if ($existing instanceof EmailContent) {
            return $existing;
        }

        /** @var EmailContent $content */
        $content = $manager->getNew();
        $content->hash = $hash;
        $content->body = $this->body;
        $content->insert();

        return $content;
    }

    protected function manager(): EmailContents
    {
        /** @var EmailContents $manager */
        $manager = MailModuleModels::emailContents();

        return $manager;
    }
}
