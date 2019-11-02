<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobsRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobsRolesTable Test Case
 */
class JobsRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\JobsRolesTable
     */
    public $JobsRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.JobsRoles',
        'app.Jobs',
        'app.Roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('JobsRoles') ? [] : ['className' => JobsRolesTable::class];
        $this->JobsRoles = TableRegistry::getTableLocator()->get('JobsRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JobsRoles);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
