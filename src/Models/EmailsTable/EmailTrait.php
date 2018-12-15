<?php

namespace Nip\MailModule\Models\EmailsTable;

use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use Nip\Mail\Models\Mailable\RecordTrait as MailableRecordTrait;
use Nip\Mail\Models\MergeTags\RecordTrait as MergeTagsRecordTrait;
use Nip\Records\AbstractModels\Record;
use Nip_File_System;
use Swift_Attachment;
use Nip\Mail\Mailer;
use Nip\Mail\Message;

/**
 * Trait EmailTrait
 * @package Nip\Mail\Models\EmailsTable
 *
 * @property int $id_item
 * @property string $type
 * @property string $from
 * @property string $from_name
 * @property string $smtp_host
 * @property string $smtp_user
 * @property string $smtp_password
 * @property string $to
 * @property string $subject
 * @property string $compiled_subject
 * @property string $body
 * @property string $compiled_body
 * @property string $vars
 * @property string $is_html
 * @property string $sent
 * @property string $date_sent
 * @property string $created
 */
trait EmailTrait
{
    use MailableRecordTrait;
    use MergeTagsRecordTrait {
        generateMergeTags as generateMergeTagsTrait;
    }
    use HasMediaTrait;

    public function populateFromConfig()
    {
        $config = app('config');
        $this->from = $config->get('EMAIL.from');
        $this->from_name = $config->get('EMAIL.from_name');

        $this->smtp_host = $config->get('SMTP.host');
        $this->smtp_user = $config->get('SMTP.username');
        $this->smtp_password = $config->get('SMTP.password');
    }

    /**
     * @param Record $item
     */
    public function populateFromItem($item)
    {
        $this->id_item = $item->id;
        $this->type = inflector()->singularize($item->getManager()->getTable());
    }

    /**
     * @inheritdoc
     * Used to decode html entities to proper chars
     */
    public function getFrom()
    {
        return [$this->from => html_entity_decode($this->from_name, ENT_QUOTES)];
    }

    /**
     * @return string
     */
    public function getPreviewBody()
    {
        return $this->getBody();
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->getMergeTags();
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getTos()
    {
        $emailsTos = [];
        if (preg_match_all('/\s*"?([^><,"]+)"?\s*((?:<[^><,]+>)?)\s*/', $this->to, $matches, PREG_SET_ORDER) > 0) {
            foreach ($matches as $m) {
                if (!empty($m[2])) {
                    $emailsTos[trim($m[2], '<>')] = html_entity_decode($m[1]);
                } else {
                    $emailsTos[$m[1]] = '';
                }
            }
        }

        return $emailsTos;
    }

    /**
     * @param $vars
     * @return $this
     */
    public function setVars($vars)
    {
        $this->mergeTags = $vars;

        return $this;
    }

    /**
     * @return mixed
     */
    public function insert()
    {
        $this->saveMergeTagsToDbField();
        $this->created = date(DATE_DB);

        return parent::insert();
    }

    public function delete()
    {
        $this->clearAttachments();
        return parent::delete();
    }

    public function clearAttachments()
    {
        $file = $this->getFiles()->delete();
    }

    /**
     * @inheritdoc
     * Used to decode html entities to proper chars
     */
    protected function generateMergeTags()
    {
        $mergeTags = $this->generateMergeTagsTrait();
        $mergeTags = array_map(
            function ($item) {
                return is_string($item) ? html_entity_decode($item, ENT_QUOTES) : $item;
            },
            $mergeTags
        );

        return $mergeTags;
    }

    /**
     * @param Message $message
     */
    public function buildMailMessageAttachments(&$message)
    {
        $emailFiles = $this->getFiles();
        foreach ($emailFiles as $emailFile) {
            $message->attach(
                Swift_Attachment::newInstance($emailFile->read(), $emailFile->getName())
            );
        }
    }

    /**
     * @return array|null
     */
    protected function getCustomArgs()
    {
        $args = [];
        $args['category'] = $this->type;
        $args['id_email'] = $this->id;

        return $args;
    }

    /**
     * @param null $value
     * @return bool
     */
    public function IsHTML($value = null)
    {
        if (is_bool($value)) {
            $this->is_html = $value ? 'yes' : 'no';
        }

        return $this->is_html == 'yes';
    }

    /**
     * @return mixed
     */
    public function getActivitiesByEmail()
    {
        if (!$this->getRegistry()->exists('activities-email')) {
            $actEmail = [];
            $activities = $this->getActivities();
            foreach ($activities as $activity) {
                $actEmail[$activity->email][] = $activity;
            }
            $this->getRegistry()->set('activities-email', $actEmail);
        }

        return $this->getRegistry()->get('activities-email');
    }

    /**
     * @return mixed
     */
    public function getLinksByEmail()
    {
        if (!$this->getRegistry()->exists('links-email')) {
            $linksEmail = [];
            $links = $this->getLinks();
            foreach ($links as $link) {
                $actEmail[$link->url][$link->email] = $link;
            }
            $this->getRegistry()->set('links-email', $actEmail);
        }

        return $this->getRegistry()->get('links-email');
    }

    /**
     * @param Mailer $mailer
     * @param Message $message
     * @param $response
     */
    protected function afterSend($mailer, $message, $response)
    {
        if ($response > 0) {
            $this->sent = 'yes';
            $this->smtp_user = '';
            $this->smtp_host = '';
            $this->smtp_password = '';
//            $this->subject = '';
//            $this->body = '';
            //        $this->vars = '';
            $this->date_sent = date(DATE_DB);
            $this->update();

            $this->clearAttachments();
        }
    }
}
