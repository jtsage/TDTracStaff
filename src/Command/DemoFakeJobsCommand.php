<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class DemoFakeJobsCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$parser->setDescription('Populate TDTracStaff with Fake Jobs');
		$parser->addArgument('number', [
			'help' => 'Number of jobs to add',
			'required' => true,
		]);
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$num = $args->getArgument('number');

		$faker = \Faker\Factory::create();

		$this->loadModel("Jobs");
		$this->loadModel("Roles");
		$this->loadModel("JobsRoles");

		$fake_companies = ["Company #1", "Company #2", "Company #3"];
		
		$rows = [];
		
		for ( $i = 0; $i < $num; $i++ ) {
			$is_active = $faker->boolean(75);
			$is_open   = ( $is_active ) ? 1 : $faker->boolean(70);

			$start = $faker->dateTimeBetween('-1 month', '+1 month');

			$end   = clone $start;
			date_modify($end, '+'.random_int(0,4).' days');

			$pay   = clone $end;
			date_modify($pay, "+1 day");

			$paid  = new \DateTime;
			$paid2 = new \DateTime;
			date_modify($paid, "+2 months");
			$paid2->setDate($paid->format("Y"), $paid->format("m"), 15);

			$rows[] = [
				"name"                  => $faker->text(60),
				"detail"                => $faker->text(60),
				"notes"                 => $faker->paragraph,
				"location"              => preg_replace("/\n/", ", ", $faker->address),
				"category"              => $faker->randomElement($fake_companies),
				"date_start"            => $start->format("Y-m-d"),
				"date_end"              => $end->format("Y-m-d"),
				"due_payroll_submitted" => $pay->format("Y-m-d"),
				"due_payroll_paid"      => $paid2->format("Y-m-d"),
				"has_payroll"           => 1,
				"has_budget"            => $faker->boolean(45),
				"has_budget_total"      => ( random_int(1,32) * 100 ),
				"time_string"           => $faker->sentence(3),
				"is_open"               => $is_open,
				"is_active"             => $is_active
			];
		}

		$entities = $this->Jobs->newEntities($rows);
		$insJobs = $this->Jobs->saveMany($entities);

		$io->out($num . " Fake Jobs Added");

		$roles = $this->Roles->find("all")->select(["id"]);

		$rows = [];

		foreach ( $insJobs as $job ) {
			foreach ( $roles as $role ) {
				if ( random_int(0,10) < 4 ) {
					$rows[] = [
						"job_id"        => $job->id,
						"role_id"       => $role->id,
						"number_needed" => random_int(1,4)
					];
				}
			}
		}

		$entities = $this->JobsRoles->newEntities($rows);
		$results  = $this->JobsRoles->saveMany($entities);

		$io->out("Staff Required Information generated for added jobs");
	}
}