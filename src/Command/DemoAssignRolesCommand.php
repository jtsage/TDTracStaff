<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoAssignRolesCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Role Mapping - DESTRUCTIVE!');
		$parser->addArgument('sure', [
			'help' => 'Are you sure?',
			'required' => true,
			'choices' => ['yes', 'YES']
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$faker = \Faker\Factory::create();

		$this->loadModel("Roles");
		$this->loadModel("UsersRoles");
		$this->loadModel("Users");

		$roles = $this->Roles->find("all")->select(["id"]);

		$arrRoles = [];

		foreach ( $roles as $role ) {
			$arrRoles[] = $role->id;
		}
		$numRoles = count($arrRoles);

		$users = $this->Users->find("all")->select(["id"]);

		$rows = [];

		foreach ( $users as $user ) {

			$theseRoles = $faker->randomElements(
				$arrRoles,
				$count = random_int(1, $numRoles-2)
			);

			foreach ( $theseRoles as $role ) {
				$rows[] = [
					"user_id" => $user->id,
					"role_id" => $role
				];
			}
		}

		$this->UsersRoles->deleteAll([1 => 1]);
		$entities = $this->UsersRoles->newEntities($rows);
		$result   = $this->UsersRoles->saveMany($entities);
		$io->out("Roles Assigned");
	}
}