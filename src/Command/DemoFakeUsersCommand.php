<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoFakeUsersCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Users');
		$parser->addArgument('number', [
			'help' => 'Number of users to add',
			'required' => true,
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$num = $args->getArgument('number');

		$faker = \Faker\Factory::create();

		$this->loadModel("Users");

		$rows = [];
		for ( $i = 0; $i < $num; $i++ ) {
			$rows[] = [
				"username"            => $faker->safeEmail,
				"first"               => $faker->firstName,
				"last"                => $faker->lastName,
				"password"            => $faker->colorName,
				"is_active"           => 1,
				"is_verified"         => 1,
				"is_password_expired" => 0,
				"is_budget"           => $faker->boolean(35)
			];
		}
		
		$entities = $this->Users->newEntities($rows);
		$result = $this->Users->saveMany($entities);

		$io->out($num . ' Fake Users Added');
	}
}