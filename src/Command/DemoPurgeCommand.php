<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoPurgeCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Command to purge some TDTracStaff tables.');
		$parser->addArgument('table', [
			'help'     => 'Which table to purge?',
			'required' => true
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$table = $args->getArgument('table');

		switch ( $table ) {
			case "payrolls" :
				$this->loadModel("Payrolls");
				$this->Payrolls->deleteAll([ 1 => 1 ]);
				$io->out("Payrolls table purged.");
				break;
			case "roles" :
				$this->loadModel("Roles");
				$this->Roles->deleteAll([ 1 => 1 ]);
				$io->out("Roles table purged.");
				break;
			case "users" :
				$this->loadModel("Users");
				$this->Users->deleteAll([ 1 => 1 ]);
				$io->out("Users table purged.");
				break;
			default :
				$io->out("Invalid table");
				break;
		}
	}
}