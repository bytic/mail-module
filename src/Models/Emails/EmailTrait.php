<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use Nip\Mail\Message;
use Nip\Mail\Models\Mailable\RecordTrait as MailableRecordTrait;
use Nip\MailModule\Models\Emails\Traits\MergeTags\MergeTagsRecordTrait;
use Nip\Records\AbstractModels\Record;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Trait EmailTrait.
 *
 * @property int    $id_item
 * @property string $type
 * @property string $smtp_host
 * @property string $smtp_user
 * @property string $smtp_password
 * @property string $to
 * @property string $reply_to
 * @property string $bcc
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
    use HasMediaTrait;
    use MailableRecordTrait;
    use MergeTagsRecordTrait;
    use TimestampableTrait;

    public ?string $body = null;

    public ?string $from = '';
    public ?string $from_name = '';

    public ?string $subject = '';

    protected static $createTimestamps = 'created';

    public function populateFromConfig()
    {
        $config = app('config');
        $this->from = $config->get('mail.from.address');
        $this->from_name = $config->get('mail.from.name');
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
     * {@inheritdoc}
     * Used to decode html entities to proper chars
     */
    public function getFrom()
    {
        if (empty($this->getPropertyRaw('from'))) {
            $config = app('config');
            $this->from = $config->get('mail.from.address');
            $this->from_name = $config->get('mail.from.name');
        }

        return html_entity_decode($this->from_name, \ENT_QUOTES) . ' <' . $this->from . '>';
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
     * @return string
     */
    public function getSubject(): ?string
    {
        return html_entity_decode($this->subject);
    }

    /**
     * @return array
     */
    public function getTos()
    {
//        $emailsTos = [];
//        if (preg_match_all('/\s*"?([^><,"]+)"?\s*((?:<[^><,]+>)?)\s*/', (string) $this->to, $matches,
//            \PREG_SET_ORDER) > 0) {
//            foreach ($matches as $m) {
//                if (!empty($m[2])) {
//                    $emailsTos[trim($m[2], '<>')] = html_entity_decode($m[1]);
//                } else {
//                    $emailsTos[$m[1]] = '';
//                }
//            }
//        }

        return explode(',', $this->get('to'));
    }

    /**
     * @return array
     */
    public function getReplyTos()
    {
        if (empty($this->reply_to)) {
            return null;
        }

        return [$this->reply_to => html_entity_decode($this->from_name, \ENT_QUOTES)];
    }

    /**
     * @return array
     */
    public function getBccs()
    {
        if (empty($this->bcc)) {
            return null;
        }

        return [$this->bcc => ''];
    }

    public function delete()
    {
        $this->clearAttachments();
        parent::delete();
    }

    public function clearAttachments()
    {
        $this->getFiles()->delete();
    }

    /**
     * @param Message $message
     */
    public function buildMailMessageAttachments(&$message)
    {
        $emailFiles = $this->getFiles();
        foreach ($emailFiles as $emailFile) {
            $message->attachFromContent($emailFile->read(), $emailFile->getName());
        }
    }

    protected function getCustomArgs(): ?array
    {
        $args = [];
        $args['category'] = $this->type;
        $args['id_email'] = $this->id;

        return $args;
    }

    /**
     * @param null $value
     *
     * @return bool
     *
     * @noinspection PhpUnused
     * @noinspection PhpMethodNamingConventionInspection
     */
    public function IsHTML($value = null)
    {
        if (\is_bool($value)) {
            $this->is_html = $value ? 'yes' : 'no';
        }

        return 'yes' == $this->is_html;
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
     * @param MailerInterface $mailer
     * @param Message         $message
     * @param $response
     */
    protected function afterSend($mailer, $message)
    {
        $this->sent = 'yes';
        $this->smtp_user = '';
        $this->smtp_host = '';
        $this->smtp_password = '';
//            $this->subject = '';
//            $this->body = '';
        //        $this->vars = '';
        $this->date_sent = date('Y-m-d H:i:s');
        $this->update();

        $this->clearAttachments();
    }
}
