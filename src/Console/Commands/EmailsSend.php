<?php

namespace Nip\MailModule\Console\Commands;

use Exception;
use Nip\Records\Collections\Collection as RecordCollection;
use Nip\Records\Locator\ModelLocator;

/**
 * Class EmailsSend
 * @package Nip\MailModule\Console\Commands
 */
class EmailsSend
{
    /**
     * @return int
     */
    public function handle()
    {
        $sent = 0;
        $batchCount = 1;
        while ($sent < 10) {
            $sentEmails = $this->sendBatch($batchCount);
            if ($sentEmails === false) {
                return $sent;
            }
            $sent += $this->sendBatch($batchCount);
            $batchCount++;
        }
        return $sent;
    }

    /**
     * @param int $number
     * @return int
     */
    protected function sendBatch($number = 1)
    {
        $emailsCount = 10;
        $emails = $this->getEmailsBatch($emailsCount, $emailsCount * ($number - 1));
        return $this->sendEmails($emails);
    }

    /**
     * @param $emails
     * @return int|bool
     */
    protected function sendEmails($emails)
    {
        if (count($emails) < 1) {
            return false;
        }
        $sent = 0;
        $recipients = 0;
        foreach ($emails as $email) {
            echo 'send email [ID:' . $email->id . '][TO:' . implode(',', array_keys($email->getTos())) . ']';
            try {
                $recipients = $email->send();
                $sent++;
            } catch (Exception $exception) {
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
     * @return RecordCollection
     */
    protected function getEmailsBatch($count = 10, $offset = 0)
    {
        $emailsManager = ModelLocator::get('emails');
        return $emailsManager->findByParams(
            [
                'where' => ['`sent` = \'no\' '],
                'limit' => $offset . ',' . $count,
            ]
        );
    }
}
