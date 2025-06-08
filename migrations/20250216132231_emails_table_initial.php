<?php
declare(strict_types=1);

use Nip\MailModule\Utility\MailModuleModels;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class EmailsTableInitial extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table_name = MailModuleModels::emailsTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name, ['primary_key' => 'id', 'id' => false]);
        $table
            ->addColumn('id', 'biginteger', ['identity' => true, 'signed' => false])
            ->addColumn('id_organizer', 'integer', ['null' => false])
            ->addColumn('id_item', 'integer', ['null' => true])
            ->addColumn('type', 'string', ['null' => true])
            ->addColumn('id_requester', 'integer', ['null' => true])
            ->addColumn('requester', 'string', ['null' => true])
            ->addColumn('from', 'string', ['null' => true])
            ->addColumn('from_name', 'string', ['null' => true])
            ->addColumn('to', 'string', ['null' => true])
            ->addColumn('reply_to', 'string', ['null' => true])
            ->addColumn('bcc', 'string', ['null' => true])
            ->addColumn('is_html', 'enum', ['null' => true, 'values' => ['yes', 'no'], 'default' => 'yes'])
            ->addColumn('subject', 'string')
            ->addColumn('body', 'text', ['limit' => MysqlAdapter::BLOB_LONG])
            ->addColumn('vars', 'text', ['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('compiled_subject', 'string')
            ->addColumn('compiled_body', 'text', ['limit' => MysqlAdapter::BLOB_LONG])
            ->addColumn('sent', 'enum', ['null' => false, 'values' => ['yes', 'no'], 'default' => 'no'])
            ->addColumn('compressed', 'enum', ['null' => false, 'values' => ['yes', 'no'], 'default' => 'no'])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_sent', 'timestamp', []);


        $table
            ->addIndex(['sent'])
            ->addIndex(['id_organizer'])
            ->addIndex(['id_item'])
            ->addIndex(['type'])
            ->addIndex(['compressed'])
            ->addIndex(['created'])
            ->addIndex(['date_sent'])
            ->addIndex(['id_requester'])
            ->addIndex(['requester'])
            ->addIndex(['to'])
        ;

        $table->save();
    }
}
