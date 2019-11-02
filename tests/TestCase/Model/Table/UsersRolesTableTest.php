<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersRolesTable Test Case
 */
class UsersRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersRolesTable
     */
    public $UsersRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UsersRoles',
        'app.Users',
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
        $config = TableRegistry::getTableLocator()->exists('UsersRoles') ? [] : ['className' => UsersRolesTable::class];
        $this->UsersRoles = TableRegistry::getTableLocator()->get('UsersRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersRoles);

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
