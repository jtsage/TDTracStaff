<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoAssignJobsCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Assignment Mapping - DESTRUCTIVE!');
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

		$this->loadModel("UsersJobs");
		$this->loadModel("Jobs");
		$this->loadModel("Users");

		$rows = [];

		$roleList = [];

		$users = $this->Users->find("all")
			->contain(["Roles"])
			->where(["is_active = 1"]);

		foreach ( $users as $user ) {
			foreach ( $user->roles as $role ) {
				$roleList[$role->id][] = $user->id;
			}
		}
		$io->verbose("Role list:" . var_export($roleList, true));


		$jobs = $this->Jobs->find("all")
			->contain(["Roles"])
			->where(["is_active = 1"]);

		foreach ( $jobs as $job ) {
			$io->verbose("Job: " . $job->name);
			$jobRoles = [];
			foreach ( $job->roles as $role ) {
				$jobRoles[] = $role->id;
			}
			foreach ( $jobRoles as $thisRole ) {
				foreach ( $roleList[$thisRole] as $user ) {
					$is_avail = $faker->boolean(55);
					$is_sched = ( $is_avail ) ? $faker->boolean(40) : 0;
					$rows[] = [
						'user_id'      => $user,
						'job_id'       => $job->id,
						'role_id'      => $thisRole,
						'is_available' => $is_avail,
						'is_scheduled' => $is_sched
					];
				}
			}
			$io->verbose("Role list: " . var_export($jobRoles, true));

		}

		$io->verbose("Inserts: " . var_export($rows, true));
			
		$this->UsersJobs->deleteAll([1 => 1]);
		$entities = $this->UsersJobs->newEntities($rows);
		$result   = $this->UsersJobs->saveMany($entities);
		$io->out("Jobs Staffed");
	}
}