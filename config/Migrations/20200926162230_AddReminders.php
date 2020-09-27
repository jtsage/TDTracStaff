<?php
use Migrations\AbstractMigration;

class AddReminders extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $app_configs = array(
            array('id'=>'dcb1bd2c-df45-4eb5-95a8-2553ba1ec9b5', 'key_name' => 'hours-due-email','value_short' => 'Sent when hours are due, a reminder e-mail','value_long' => 'Good day!\n\nYou are receiving the e-mail to remind you that hours are due very soon.  At your earliest connivence, please log in and make sure that any hours you have worked have been added to the system.\n\n@@@{{server-name}}/payrolls/add/|Add your hours@@@\n\nThank you for your time today!\n\n_~{{admin-name}}_\n<{{admin-email}}>'),
        );
        

        $this->table('app_configs')->insert($app_configs)->save();

        $this->table('reminders', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('start_time', 'date', [
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('type', 'integer', [
                'default' => 1,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('period', 'integer', [
                'default' => 7,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('last_run', 'timestamp', [
                'default' => '1970-01-01 00:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('toUsers', 'text', [
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'limit' => 250,
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
