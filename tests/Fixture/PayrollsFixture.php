<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayrollsFixture
 */
class PayrollsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_worked' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'time_start' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => '08:00:00', 'comment' => '', 'precision' => null],
        'time_end' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => '17:00:00', 'comment' => '', 'precision' => null],
        'hours_worked' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_paid' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'job_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '1970-01-01 05:00:01', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'job_id' => ['type' => 'index', 'columns' => ['job_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'payrolls_ibfk_1' => ['type' => 'foreign', 'columns' => ['job_id'], 'references' => ['jobs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'payrolls_ibfk_2' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 'fd8396db-d17e-462f-80b0-035f4828e593',
                'date_worked' => '2019-11-01',
                'time_start' => '17:00:35',
                'time_end' => '17:00:35',
                'hours_worked' => 1,
                'is_paid' => 1,
                'user_id' => 'fa8ec25c-c19b-4b94-aaa7-6bfa9a18b2bc',
                'job_id' => '815986d4-677a-4e21-b932-16258cd3de09',
                'created_at' => 1572627635,
                'updated_at' => 1572627635
            ],
        ];
        parent::init();
    }
}
