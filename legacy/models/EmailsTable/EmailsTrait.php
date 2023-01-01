<?php

namespace Nip\MailModule\Models\EmailsTable;

use Nip\MailModule\Models\EmailsTable\Traits\Cleanup\RecordsTrait as CleanupRecordsTrait;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\EventManager\Events\Event;
use Nip\Records\Record;

/**
 * Trait EmailsTrait
 * @deprecated use Nip\MailModule\Models\Emails\EmailsTrait
 */
trait EmailsTrait
{
    use \Nip\MailModule\Models\Emails\EmailsTrait;
}
