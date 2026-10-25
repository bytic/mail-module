<?php

declare(strict_types=1);

use Nip\MailModule\Models\EmailActivities\EmailActivities;
use Nip\MailModule\Models\EmailContents\EmailContents;
use Nip\MailModule\Models\EmailLinks\EmailLinks;
use Nip\MailModule\Models\Emails\Emails;
use Nip\MailModule\Utility\MailModuleModels;

return [
    'models' => [
        MailModuleModels::EMAILS => Emails::class,
        MailModuleModels::ACTIVITIES => EmailActivities::class,
        MailModuleModels::LINKS => EmailLinks::class,
        MailModuleModels::EMAIL_CONTENTS => EmailContents::class,
    ],

    'tables' => [
        MailModuleModels::EMAILS => Emails::TABLE,
        MailModuleModels::ACTIVITIES => EmailActivities::TABLE,
        MailModuleModels::LINKS => EmailLinks::TABLE,
        MailModuleModels::EMAIL_CONTENTS => EmailContents::TABLE,
    ],

    'database' => [
        'connection' => 'main',
        'migrations' => true,
    ],
];
