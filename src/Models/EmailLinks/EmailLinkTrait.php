<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailLinks;

use Nip\Database\Query\Insert;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Trait LinkTrait.
 */
trait EmailLinkTrait
{
    use AbstractRecordTrait;

    /**
     * @return Insert
     */
    public function incrementQueryFromSendGrid($notification)
    {
        $cols = ['hash', 'id_email', 'email', 'smtp-id', 'category', 'url', 'ip', 'useragent', 'clicks'];
        /** @var Insert $query */
        $query = $this->newQuery('insert');
        $query->setCols($cols);

        $notification['hash'] = sha1($notification['id_email'] . $notification['email'] . $notification['url']);
        $values = [];
        foreach ($cols as $col) {
            $values[$col] = $notification[$col];
        }
        $values['clicks'] = 1;
        $query->data($values);
        $onDuplicate = ['clicks' => ['`clicks`+1', false]];
        $query->onDuplicate($onDuplicate);

        return $query;
    }
}
