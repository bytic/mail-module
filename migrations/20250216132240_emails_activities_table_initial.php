<?php
declare(strict_types=1);

use Nip\MailModule\Utility\MailModuleModels;
use Phinx\Migration\AbstractMigration;

final class EmailsActivitiesTableInitial extends AbstractMigration
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
        $table_name = MailModuleModels::activitiesTable();
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name, ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'biginteger', ['identity' => true, 'signed' => false])
            ->addColumn('id_email', 'biginteger', ['signed' => false])
            ->addColumn('smtp_id', 'string', ['null' => true])
            ->addColumn('event', 'string', ['null' => true])
            ->addColumn('category', 'string', ['null' => true])
            ->addColumn('email', 'string', ['null' => true])
            ->addColumn('timestamp', 'timestamp', ['null' => true])
            ->addColumn('values', 'text')
            ->addIndex(['id_email'])
        ;

        $table->save();
    }
}
