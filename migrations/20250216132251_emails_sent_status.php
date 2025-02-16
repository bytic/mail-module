<?php
declare(strict_types=1);

use Nip\MailModule\Utility\MailModuleModels;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class EmailsSentStatus extends AbstractMigration
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
        $table = $this->table($table_name);
        $table
            ->changeColumn(
                'sent',
                'enum',
                ['null' => false, 'values' => ['yes', 'no', 'error'], 'default' => 'no']
            );
        $table->save();
    }
}
