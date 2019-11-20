<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MailQueuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MailQueuesTable Test Case
 */
class MailQueuesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MailQueuesTable
     */
    public $MailQueues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MailQueues'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MailQueues') ? [] : ['className' => MailQueuesTable::class];
        $this->MailQueues = TableRegistry::getTableLocator()->get('MailQueues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MailQueues);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
