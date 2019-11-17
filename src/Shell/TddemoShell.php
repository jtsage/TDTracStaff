<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\InternalErrorException;
//use Cake\I18n\Time;
//use Cake\Mailer\Email;
//use Cake\ORM\TableRegistry;
//use Cake\Core\Configure;
//use Cake\Chronos\Chronos;

/**
 * Theater Bio shell command.
 */
class TddemoShell extends Shell
{

	public function getOptionParser()
	{
		$parser = parent::getOptionParser();
		$parser
			->setDescription('A small set of utilities to streamline the TDTracStaff demo')
			->addSubcommand('addProdRoles', [
				'help' => 'Add Production Roles',
				'parser' => [
					'description' => 'Add production roles to list of trainable roles.',
				]
			])
			->addSubcommand('addTeachRoles', [
				'help' => 'Add Instructor Roles',
				'parser' => [
					'description' => 'Add instructor roles to list of trainable roles',
				]
			]);
		return $parser;
	}
	/**
	 * main() method.
	 *
	 * @return bool|int Success or error code.
	 */
	public function main() 
	{
		return $this->out($this->getOptionParser()->help());
	}

	public function addProdRoles() {
		$this->loadModel("Roles");

		$rows = [
			[ 'title' => 'Driver', 'detail' => 'Certified to drive trucking to, from, and at events', 'sort_order' => '600' ],
			[ 'title' => 'Stagehand', 'detail' => 'On site stagehand', 'sort_order' => '400' ],
			[ 'title' => 'Event Tech I - Video', 'detail' => 'On site video technician', 'sort_order' => '203' ],
			[ 'title' => 'Help Desk', 'detail' => 'Offsite Help', 'sort_order' => '1' ],
			[ 'title' => 'Field Lead', 'detail' => 'In charge of all on-site aspects, main contact person on-site', 'sort_order' => '100' ],
			[ 'title' => 'Shop Lead', 'detail' => 'In charge of all pre-site aspects, main contact person at shop', 'sort_order' => '101' ],
			[ 'title' => 'Intern', 'detail' => 'On or Off site technician in training', 'sort_order' => '900' ],
			[ 'title' => 'Event Tech I - Audio', 'detail' => 'On site audio technician', 'sort_order' => '201' ],
			[ 'title' => 'Event Tech I - Lighting', 'detail' => 'On site lighting technician', 'sort_order' => '202' ],
			[ 'title' => 'Utility', 'detail' => 'On site utility worker', 'sort_order' => '500' ],
			[ 'title' => 'Event Tech II', 'detail' => 'On site technician', 'sort_order' => '300' ]
		];
		
		$entities = $this->Roles->newEntities($rows);
		$result = $this->Roles->saveMany($entities);
	}

	public function addTeachRoles() {
		$this->loadModel("Roles");

		$rows = [
			[ 'title' => 'Ballet Instructor', 'detail' => 'Cover for Ballet Classes', 'sort_order' => '701' ],
			[ 'title' => 'Tap Instructor', 'detail' => 'Cover for Tap Classes', 'sort_order' => '702' ],
			[ 'title' => 'Jazz Instructor', 'detail' => 'Cover for Jazz Classes', 'sort_order' => '703' ],
			[ 'title' => 'Accompanist', 'detail' => 'Can play for students / professionals', 'sort_order' => '801' ],
			[ 'title' => 'MT Instructor', 'detail' => 'Cover for Acting, Voice, MTW classes', 'sort_order' => '704' ],
			[ 'title' => 'Tech Instructor', 'detail' => 'Cover for technical work', 'sort_order' => '802' ],
			[ 'title' => 'Stage Management', 'detail' => 'Cover for stage management duties', 'sort_order' => '803' ]
		];
		
		$entities = $this->Roles->newEntities($rows);
		$result = $this->Roles->saveMany($entities);
	}


	
}
