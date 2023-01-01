<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails;

use Nip\MailModule\Models\Emails\Traits\Cleanup\RecordsTrait as CleanupRecordsTrait;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\EventManager\Events\Event;
use Nip\Records\Record;

/**
 * Trait EmailsTrait.
 */
trait EmailsTrait
{
    use CleanupRecordsTrait;

    public function bootEmailsTrait()
    {
        static::creating(function (Event $event) {
            /** @var EmailTrait|Record $record */
            $record = $event->getRecord();
            /** @var static|RecordManager $manager */
            $record->setIfEmpty('sent', 'no');
            $record->setIfEmpty('compressed', 'no');

            $record->saveMergeTagsToDbField();
        });
    }
}
