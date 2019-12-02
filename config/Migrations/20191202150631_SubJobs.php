<?php
use Migrations\AbstractMigration;

class SubJobs extends AbstractMigration
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
        $this->table('jobs')
            ->addColumn('parent_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->update();
    }
}
