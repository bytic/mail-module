<?php
declare(strict_types=1);

use Nip\MailModule\Utility\MailModuleModels;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class EmailsLinksTableInitial extends AbstractMigration
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
        $table_name = MailModuleModels::linksTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name, ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'biginteger', ['identity' => true, 'signed' => false])
            ->addColumn('id_email', 'biginteger', ['signed' => false])
            ->addColumn('email', 'string', ['null' => true])
            ->addColumn('smtp-id', 'string', ['null' => true])
            ->addColumn('category', 'string', ['null' => true])
            ->addColumn('url', 'string', ['null' => true])
            ->addColumn('ip', 'string', ['null' => true])
            ->addColumn('useragent', 'string', ['null' => true])
            ->addColumn('clicks', 'integer', ['limit' => MysqlAdapter::INT_TINY])
            ->addIndex(['id_email'])
            ->addIndex(['email'])
        ;

        $table->save();
    }
}
