<?php

declare(strict_types=1);

namespace Nip\MailModule\Console\Commands;

use Nip\MailModule\Models\Emails\Email;
use Nip\Records\Collections\Collection as RecordCollection;

/**
 * Class EmailsSend.
 */
class EmailsSend extends EmailsAbstract
{
    public const NAME = 'emails:send';

    /**
     * @return int
     */
    public function handle()
    {
        $sent = 0;
        $batchCount = 1;
        while ($sent < 10) {
            $sentEmails = $this->sendBatch($batchCount);
            if (false === $sentEmails) {
                return $sent;
            }
            $sent += $this->sendBatch($batchCount);
            ++$batchCount;
        }

        return $sent;
    }

    /**
     * @param int $number
     *
     * @return int|bool
     */
    protected function sendBatch($number = 1)
    {
        $emailsCount = 10;
        $emails = $this->getEmailsBatch($emailsCount, $emailsCount * ($number - 1));

        return $this->sendEmails($emails);
    }

    /**
     * @param RecordCollection|Email $emails
     *
     * @return int|bool
     */
    protected function sendEmails($emails)
    {
        if (\count($emails) < 1) {
            return false;
        }
        $sent = 0;
        $recipients = 0;
        foreach ($emails as $email) {
            echo 'send email [ID:' . $email->id . '][TO:' . implode(',', $email->getTos()) . ']';
            try {
                $recipients = $email->send();
                ++$sent;
            } catch (\Exception $exception) {
                echo $exception->getMessage();
//            die('');
            }
            echo '[R:' . $recipients . ']<br />' . "\n";
        }

        return $sent;
    }

    /**
     * @param int $count
     * @param int $offset
     *
     * @return RecordCollection
     */
    protected function getEmailsBatch($count = 10, $offset = 0)
    {
        $emailsManager = $this->emailsManager();

        return $emailsManager->findByParams(
            [
                'where' => [
                    '(`sent` = \'no\' OR `sent` IS NULL OR `sent` = \'\') ',
                    '(`to` != "" AND `to` IS NOT NULL)',
                ],
                'limit' => $offset . ',' . $count,
            ]
        );
    }
}
