<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoFakeBudgetCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Budget Information');
		$parser->addArgument('max', [
			'help' => 'Maximum Entries Per Show?',
			'required' => true,
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$num = $args->getArgument('max');

		$faker = \Faker\Factory::create();

		$this->loadModel("Users");
		$this->loadModel("Jobs");
		$this->loadModel("Budgets");

		$rows = [];

		$users = $this->Users->find("all")
			->where(["is_budget" => 1]);

		$userList = [];

		foreach ( $users as $user ) {
			$userList[] = $user->id;
		}
		
		$io->verbose("User List: " . var_export($userList, true));

		$jobs = $this->Jobs->find("all")
			->where(["has_budget = 1"]);

		foreach ( $jobs as $job ) {
			$io->verbose("Job: " . $job->name);

			$tries = random_int(0,$num);

			for ( $i = 0; $i < $tries; $i++ ) {
				$date = $faker->dateTimeBetween($job->date_start, $job->date_end);

				$rows[] = [
					'date'     => $date->format("Y-m-d"),
					'vendor'   => $faker->text(30),
					'category' => $faker->text(30),
					'detail'   => $faker->text(105),
					'amount'   => (random_int(100,70000) / 100),
					'user_id'  => $faker->randomElement($userList),
					'job_id'   => $job->id
				];
			}
		}

		$io->verbose("Inserts: " . var_export($rows, true));
			
		$entities = $this->Budgets->newEntities($rows);
		$result   = $this->Budgets->saveMany($entities);

		$io->out("Fake Budgets Added");
	}
}