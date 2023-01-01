<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails;

use Nip\Records\RecordManager;

class Emails extends RecordManager
{
    use EmailsTrait;
}
