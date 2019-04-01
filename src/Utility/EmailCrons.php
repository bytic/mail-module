<?php

namespace Nip\MailModule\Utility;

use Nip\MailModule\Console\Commands\EmailsSend;
use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailCrons
 * @package Nip\MailModule\Utility
 */
class EmailCrons
{
    /**
     * @return int
     */
    public static function send()
    {
        return (new EmailsSend())->handle();
    }

    /**
     * @return int
     */
    public static function cleanup()
    {
        /** @var EmailsTrait $emailsManager */
        $emailsManager = ModelLocator::get('emails');
        $result = $emailsManager->reduceOldEmailsData();
        return $result->numRows();
    }
}
