<?php
use Migrations\AbstractMigration;

class MailQueues extends AbstractMigration
{
    public $autoId = false;
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('mail_queues')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('template', 'string', [
                'default' => "default",
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('toUser', 'string', [
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('subject', 'string', [
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('viewvars', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('body', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->create();
    }
}
