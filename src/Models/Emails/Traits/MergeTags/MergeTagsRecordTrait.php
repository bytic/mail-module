<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\Emails\Traits\MergeTags;

use Nip\Mail\Models\MergeTags\RecordTrait as MailMergeTagsRecordTrait;

/**
 * Trait MergeTagsRecordTrait.
 */
trait MergeTagsRecordTrait
{
    use MailMergeTagsRecordTrait {
        generateMergeTags as generateMergeTagsTrait;
        saveMergeTagsToDbField as saveMergeTagsToDbFieldTrait;
    }

    /**
     * @return $this
     */
    public function setVars($vars)
    {
        if (\is_string($vars)) {
            $this->setDataValue('vars', $vars);
        } else {
            $this->setMergeTags($vars);
            $this->saveMergeTagsToDbField();
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

    public function saveMergeTagsToDbField()
    {
        $this->saveMergeTagsToDbFieldTrait();
    }

    /**
     * {@inheritdoc}
     * Used to decode html entities to proper chars
     */
    protected function generateMergeTags()
    {
        $mergeTags = $this->generateMergeTagsTrait() ?: [];
        $mergeTags = array_map(
            function ($item) {
                return \is_string($item) ? html_entity_decode($item, \ENT_QUOTES) : $item;
            },
            $mergeTags
        );

        return $mergeTags;
    }
}
