<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoFakePayrollCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Payroll Information');
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

		$this->loadModel("UsersJobs");
		$this->loadModel("Jobs");
		$this->loadModel("Payrolls");

		$rows = [];


		$jobs = $this->Jobs->find("all")
			->contain(["Roles"])
			->where(["is_open = 1"]);

		foreach ( $jobs as $job ) {
			$io->verbose("Job: " . $job->name);

			$jobUsers = [];
			
			$usersSched = $this->UsersJobs->find("all")
				->select(["user_id"])
				->distinct(["user_id"])
				->where([
					"job_id" => $job->id,
					"is_scheduled" => 1,
				]);

			foreach ( $usersSched as $user ) {
				$jobUsers[] = $user->user_id;
			}

			$io->verbose("User list: " . var_export($jobUsers, true));

			foreach ( $jobUsers as $userID ) {

				$tries = random_int(0,$num);

				for ( $i = 0; $i < $tries; $i++ ) {
					$date = $faker->dateTimeBetween($job->date_start, $job->date_end);

					$hour_start = random_int(8,12);
					$time_begin = (($hour_start < 10 ) ? "0": "") . $hour_start . ":" . ["00","15","30","45","00"][random_int(0,4)];
					$real_time_begin = \DateTime::createFromFormat("H:i", $time_begin);
					
					$hours_worked = random_int(1,9) + [0,0.25,0.5,0.75,0][random_int(0,4)];

					$real_time_end = clone $real_time_begin;
					$real_time_end->modify("+" . ($hours_worked*60) . " minutes");

					$time_end   = $real_time_end->format("H:i");

					$rows[] = [
						"user_id"      => $userID,
						"job_id"       => $job->id,
						"is_paid"      => $faker->boolean(75),
						"time_start"   => $time_begin . ":00",
						"time_end"     => $time_end . ":00",
						"hours_worked" => $hours_worked,
						"date_worked"  => $date->format("Y-m-d"),
					];
				}
			}
		}

		$io->verbose("Inserts: " . var_export($rows, true));
			
		$entities = $this->Payrolls->newEntities($rows);
		$result   = $this->Payrolls->saveMany($entities);

		$io->out("Fake Payroll Added");
	}
}