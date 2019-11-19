<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class UserAdminCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$optName = "Admin";
		$parser->setDescription("Toggle a TDTracStaff User's {$optName} Flag");
		$parser->addArgument('username', [
			'help' => 'Username of the user',
			'required' => true,
		]);
		$parser->addOption('force-yes', ['help' => "Force the {$optName} flag ON", 'boolean' => true]);
		$parser->addOption('force-no', ['help' => "Force the {$optName} flag OFF", 'boolean' => true]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$username = $args->getArgument('username');
		$forceN   = $args->getOption('force-no');
		$forceY   = $args->getOption('force-yes');

		$this->loadModel("Users");

		if ( ! $user = $this->Users->findByUsername($username)->first() ) {
			$io->error('User not found.');
			$this->abort();
		}

		$now_option = $user->is_admin;
		$new_option = ( $now_option ? 0 : 1 );

		if ( $forceN ) {
			$new_option = 0;
		}
		if ( $forceY ) {
			$new_option = 1;
		}

		$user->is_admin = $new_option;

		if ( $this->Users->save($user) ) {
			$io->out($username . " : Setting flag to : " . ($new_option?"true":"false"));
		} else {
			$io->out('Unable to update user.');
		}
	}
}