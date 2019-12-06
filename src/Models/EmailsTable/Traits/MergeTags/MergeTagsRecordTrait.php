<?php

namespace Nip\MailModule\Models\EmailsTable\Traits\MergeTags;

use Nip\Mail\Models\MergeTags\RecordTrait as MailMergeTagsRecordTrait;

/**
 * Trait MergeTagsRecordTrait
 * @package Nip\MailModule\Models\EmailsTable\Traits\MergeTags
 */
trait MergeTagsRecordTrait
{
    use MailMergeTagsRecordTrait {
        generateMergeTags as generateMergeTagsTrait;
    }

    /**
     * @param $vars
     * @return $this
     */
    public function setVars($vars)
    {
        if (is_string($vars)) {
            $this->setDataValue('vars', $vars);
        } else {
            $this->mergeTags = $vars;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->getMergeTags();
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
}
