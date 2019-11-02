<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AppConfigsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AppConfigsTable Test Case
 */
class AppConfigsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AppConfigsTable
     */
    public $AppConfigs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AppConfigs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AppConfigs') ? [] : ['className' => AppConfigsTable::class];
        $this->AppConfigs = TableRegistry::getTableLocator()->get('AppConfigs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppConfigs);

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
