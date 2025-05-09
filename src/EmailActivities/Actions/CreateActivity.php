<?php

declare(strict_types=1);

namespace Nip\MailModule\EmailActivities\Actions;

use Bytic\Actions\Action;
use Nip\MailModule\Utility\MailModuleModels;

/**
 *
 */
class CreateActivity extends Action
{
    public const ATTRIB_EVENT = 'event';
    const ATTRIB_CATEGORY = 'category';
    public const ATTRIBUTES = [
        self::ATTRIB_EVENT,
        self::ATTRIB_CATEGORY,
    ];
    protected $email;
    protected $activity;

    public static function forEmail($email)
    {
        $action = new static();
        $action->email = $email;
        return $action;
    }

    public function save()
    {
        $this->activity = $this->createActivity();


    }

    public function withEvent($event): static
    {
        $this->fillAttributes([self::ATTRIB_EVENT => $event]);
        return $this;
    }

    public function withCategory($category): static
    {
        $this->fillAttributes([self::ATTRIB_CATEGORY => $category]);
        return $this;
    }

    protected function createActivity()
    {
        $activity = MailModuleModels::activities()->getNew();
        $activity->id_email = $this->email->id;
        foreach (self::ATTRIBUTES as $key) {
            $activity->{$key} = $this->getAttribute($key);
        }
        $activity->save();
        return $activity;
    }
}