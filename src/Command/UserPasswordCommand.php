<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class UserPasswordCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription("Change a TDTracStaff User's Password");
		$parser->addArgument('username', [
			'help' => 'Username of the user',
			'required' => true,
		]);
		$parser->addArgument('password', [
			'help' => 'New Password',
			'required' => true,
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$username = $args->getArgument('username');
		$password = $args->getArgument('password');

		$this->loadModel("Users");

		if ( ! $user = $this->Users->findByUsername($username)->first() ) {
			$io->error('User not found.');
			$this->abort();
		}

		$user->password            = $password;
		$user->is_password_expired = 1;

		if ( $this->Users->save($user) ) {
			$io->out($username . " : Password Reset");
		} else {
			$io->out('Unable to update user.');
		}
	}
}