<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoStdUsersCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Standard Users');
		$parser->addArgument('sure', [
			'help' => 'Are you sure?',
			'required' => true,
			'choices' => ['yes', 'YES']
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$this->loadModel("Users");

		$rows = [
			[ 'username' => 'admin@tdtrac.com', 'first' => 'Admin', 'last' => 'User', 'password' => 'admin', 'is_admin' => 1, 'is_budget' => 1, 'is_active' => 1, 'is_verified' => 1, 'is_password_expired' => 0],
			[ 'username' => 'budget@tdtrac.com', 'first' => 'Budget', 'last' => 'User' ,'password' => 'budget', 'is_admin' => 0, 'is_budget' => 1, 'is_active' => 1, 'is_verified' => 1, 'is_password_expired' => 0],
			[ 'username' => 'regular@tdtrac.com', 'first' => 'Regular', 'last' => 'User', 'password' => 'regular', 'is_admin' => 0, 'is_budget' => 0, 'is_active' => 1, 'is_verified' => 1, 'is_password_expired' => 0]
		];
		
		$entities = $this->Users->newEntities($rows);
		$result = $this->Users->saveMany($entities);

		$io->out("Standard Users Added");
	}
}