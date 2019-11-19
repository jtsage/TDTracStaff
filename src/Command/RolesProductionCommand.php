<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class RolesProductionCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Production Based Roles');
		$parser->addArgument('sure', [
			'help' => 'Are you sure?',
			'required' => true,
			'choices' => ['yes', 'YES']
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
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

		$io->out("Production Roles Added");
	}
}