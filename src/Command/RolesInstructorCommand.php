<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class RolesInstructorCommand extends Command
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

		$io->out("Production Roles Added");
	}
}