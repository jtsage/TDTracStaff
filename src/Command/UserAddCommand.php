<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class UserAddCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription("Change a TDTracStaff User's Password");
		$parser->addArgument('username', [
			'help' => 'Username',
			'required' => true,
		]);
		$parser->addArgument('password', [
			'help' => 'Password',
			'required' => true,
		]);
		$parser->addArgument('first', [
			'help' => 'First Name of user',
			'required' => true,
		]);
		$parser->addArgument('last', [
			'help' => 'Last Name of user',
			'required' => true,
		]);
		$parser->addOption('admin', ['help' => "This user is an admin", 'boolean' => true]);
		$parser->addOption('budget', ['help' => "This user enters budget data", 'boolean' => true]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$username  = $args->getArgument('username');
		$password  = $args->getArgument('password');
		$first     = $args->getArgument('first');
		$last      = $args->getArgument('last');
		$is_admin  = $args->getOption('admin');
		$is_budget = $args->getOption('budget');

		$this->loadModel("Users");
		
		$user = $this->Users->newEntity([
			'username'            => $username,
			'password'            => $password,
			'first'               => $first,
			'last'                => $last,
			'is_verified'         => 1,
			'is_password_expired' => 1,
			'is_admin'            => ($is_admin ? 1:0 ),
			'is_budget'           => ($is_budget ? 1:0 ),
		]);

		if ( $this->Users->save($user) ) {
			$io->out("User Created");
		} else {
			$io->out('Unable to add user.');
		}
	}
}