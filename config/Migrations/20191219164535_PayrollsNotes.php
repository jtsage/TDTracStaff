<?php
use Migrations\AbstractMigration;

class PayrollsNotes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('payrolls')
            ->addColumn('notes', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->update();
    }
}
