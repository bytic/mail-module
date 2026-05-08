<?php

declare(strict_types=1);

use Nip\MailModule\Utility\MailModuleModels;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class EmailContentsTableCreate extends AbstractMigration
{
    public function change(): void
    {
        $this->createEmailContentsTable();
        $this->addBodyIdToEmailsTable();
    }

    private function createEmailContentsTable(): void
    {
        $tableName = MailModuleModels::emailContentsTable();
        if ($this->hasTable($tableName)) {
            return;
        }

        $table = $this->table($tableName, ['primary_key' => 'id', 'id' => false]);
        $table
            ->addColumn('id', 'biginteger', ['identity' => true, 'signed' => false])
            ->addColumn('hash', 'string', ['limit' => 64, 'null' => false])
            ->addColumn('body', 'text', ['limit' => MysqlAdapter::BLOB_LONG, 'null' => true])
            ->addIndex(['hash'], ['unique' => true])
            ->save();
    }

    private function addBodyIdToEmailsTable(): void
    {
        $emailsTable = MailModuleModels::emailsTable();
        $contentsTable = MailModuleModels::emailContentsTable();

        $table = $this->table($emailsTable);
        if (!$table->hasColumn('body_id')) {
            $table
                ->addColumn('body_id', 'biginteger', ['null' => true, 'signed' => false, 'after' => 'body'])
                ->addForeignKey('body_id', $contentsTable, 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION'])
                ->addIndex(['body_id'])
                ->save();
        }
    }
}
