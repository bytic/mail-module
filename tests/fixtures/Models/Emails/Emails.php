<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests\Fixtures\Models\Emails;

use Nip\MailModule\Models\EmailsTable\EmailsTrait;
use Nip\Records\RecordManager;

/**
 * Class Emails.
 */
class Emails extends RecordManager
{
    use EmailsTrait;

    /**
     * @return int[]
     */
    public static function reduceEmailsByType()
    {
        return [
            '*' => 365,
            'donation' => 365,
        ];
    }

    /**
     * @return string
     */
    public function generateTable()
    {
        return 'emails';
    }
}
