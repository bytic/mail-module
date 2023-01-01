<?php

declare(strict_types=1);

namespace Nip\MailModule\Models\AbstractModels;

use ByTIC\Records\Behaviors\HasForms\HasFormsRecordsTrait;
use Nip\I18n\Translatable\HasTranslations;
use Nip\Records\Filters\Records\HasFiltersRecordsTrait;

/**
 * Trait CommonRecordsTrait.
 */
trait CommonRecordsTrait
{
    use HasFiltersRecordsTrait;
    use HasFormsRecordsTrait;
    use HasTranslations;

    protected function generateController(): string
    {
        return $this->getTable();
    }

    /**
     * @return string
     */
    public function getTranslateRoot()
    {
        return $this->getController();
    }

    public function getRootNamespace()
    {
        return 'ByTIC\NotifierBuilder\Models\\';
    }
}
