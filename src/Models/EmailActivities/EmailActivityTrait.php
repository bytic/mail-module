<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\EmailActivities;

use Nip\Records\Traits\AbstractTrait\RecordTrait as AbstractRecordTrait;

/**
 * Trait ActivityTrait.
 *
 * @property string $values
 */
trait EmailActivityTrait
{
    use AbstractRecordTrait;

    /**
     * @param bool|array $data
     */
    public function writeDBData($data = [])
    {
        $this->values = (isset($data['values'])) ? unserialize($data['values']) : [];

        return parent::writeDBData($data);
    }

    public function initFromSendGrid($notification)
    {
        foreach (['smtp-id', 'category', 'email', 'event', 'timestamp'] as $type) {
            $varName = 'smtp-id' == $type ? 'smtp_id' : $type;
            $this->{$varName} = $notification[$type] ?? '';
            unset($notification[$type]);
        }

        $extraValues = [];
        foreach ($notification as $type => $value) {
            $extraValues[$type] = $value;
        }
        $this->values = $extraValues;
    }

    /**
     * @return string
     */
    public function getExtraInfo()
    {
        $return = [];
        foreach ($this->values as $type => $value) {
            $return[] = '<strong>' . $type . '</strong> : ' . $value;
        }

        return implode('<br />', $return);
    }

    /**
     * @return bool
     */
    public function insert()
    {
        $values = $this->values;
        $this->values = serialize($this->values);

        $return = parent::insert();
        $this->values = $values;

        return $return;
    }

    /**
     * @return bool|\Nip\Database\Result
     */
    public function update()
    {
        $values = $this->values;
        $this->values = serialize($this->values);
        $return = parent::update();
        $this->values = $values;

        return $return;
    }
}
