<?php

namespace Nip\MailModule\Utility;

use Nip\MailModule\Console\Commands\EmailsSend;

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
}
