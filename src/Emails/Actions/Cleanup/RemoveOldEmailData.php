<?php

declare(strict_types=1);

namespace Nip\MailModule\Emails\Actions\Cleanup;

use Bytic\Actions\Action;
use Nip\Database\Query\Update;
use Nip\MailModule\Utility\MailModuleModels;

/**
 *
 */
class RemoveOldEmailData extends Action
{

    protected $repository;

    public function __construct()
    {
        $this->repository = MailModuleModels::emails();
    }

    /**
     * @return int|bool
     */
    public function handle()
    {
        $query = $this->newUpdateQuery();

        $query->data([
            'vars' => '',
            'body' => '',
            'compiled_subject' => '',
            'compiled_body' => '',
        ]);

        return $query->execute();
    }

    protected function newUpdateQuery(): Update
    {
        $query = $this->repository->newUpdateQuery();
        $query->where(
            '`' . $this->repository::getSentDateField()
            . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL '
            . $this->repository->getDaysToKeepData() . ' DAY)'
        );
        return $query;
    }
}

