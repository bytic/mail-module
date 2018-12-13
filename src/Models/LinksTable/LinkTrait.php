<?php

namespace Nip\MailModule\Models\LinksTable;

use Nip\Database\Query\Insert;
use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Trait LinkTrait
 * @package Nip\MailModule\Models\LinksTable
 */
trait LinkTrait
{
    use AbstractRecordTrait;

    /**
     * @param $notification
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
