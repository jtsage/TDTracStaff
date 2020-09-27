<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\FrozenTime;
use Markdown\Parsedown\Parsedown;
use Markdown\Parsedown\ParsedownExtra;

class CronJobCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$optName = "Cron";
		$parser->setDescription("Process the cron jobs (100 max)");
		return $parser;
	}

	public function execute(Arguments $args, ConsoleIo $io)
	{
		$this->loadModel("AppConfigs");

		$config = $this->AppConfigs->find('list', [
			'keyField' => 'key_name',
			'valueField' => 'value_long'
		]);
		$configArr = $config->toArray();

		$this->loadModel("Reminders");
		

		$cronqueue = $this->Reminders->find("all")->order(["created_at" => "ASC"])->limit(100);

		$io->verbose("Today is: " . date("Y-m-d"));

		foreach ( $cronqueue as $thisCron ) {
			$verbose_string = "Processing: " . $thisCron->description . " Next Run On: " . $thisCron->start_time;
			
			// Determine run status
			if ( $thisCron->start_time->isToday() || $thisCron->start_time->isPast() ) {
				// YES, run it.
				$io->verbose($verbose_string . " (NOW!)");
				// Get Next Run Date
				$ff_warn = false;
				$next_run_date = $thisCron->start_time->addDays($thisCron->period);
				while ( ! $next_run_date->isFuture() ) {
					// Trap for dates in the past.
					$next_run_date = $next_run_date->addDays($thisCron->period);
					$ff_warn = true;
				}
				$last_run_date = FrozenTime::now();
				if ( $ff_warn ) { $io->verbose( "  - WARNING: Date Fast Forward was used!"); }
				$io->verbose("  - Set next run to: " . $next_run_date);
				$io->verbose("  - Set last run to: " . $last_run_date);

				// Do the task
				switch ( $thisCron->type ) {
					case 0:
						// Just a simple counter to note that cron is working
						$thisCron->start_time = $next_run_date;
						$thisCron->last_run = $last_run_date;
						$this->Reminders->save($thisCron);
						$io->verbose("  -- FINISHED.");
						break;
					case 1:
						// Send reminder e-mails for users to add hours.
						$this->loadModel("Users");
						$this->loadModel("MailQueues");

						$usersToEmail = json_decode($thisCron->toUsers);
						$users = $this->Users->find("all")->where(["id IN" => $usersToEmail]);

						$mailBody = $configArr["hours-due-email"];

						$mailBody = preg_replace_callback(
							"/{{([\w-]+)}}/m",
							function ($matches) use ( $configArr ) {
								if ( !empty($configArr[$matches[1]]) ) {
									return $configArr[$matches[1]];
								}
								return $matches[1];
							},
							$mailBody
						);

						$mailBody = preg_replace("/\\\\n/", "<br />\n", $mailBody);

						$md = new ParseDownExtra();
						$mailHTML = $md->setUrlsLinked(false)->parse($mailBody);

						foreach ( $users as $thisUser ) {
							$io->verbose("  - Queuing Mail for: " . $thisUser->fullName . " <" . $thisUser->username . ">" );

							$thisMail = $this->MailQueues->newEntity([
								"template" => "default",
								"toUser"   => $thisUser->username,
								"subject"  => "Payrol Hour Submission Reminder - " . date("Y-m-d"),
								"viewvars" => json_encode(['CONFIG' => $configArr]),
								"body"     => $mailHTML
							]);

							if ( $this->MailQueues->save($thisMail) ) {
								$io->verbose("    ...done");
							} else {
								$io->warning("  - Mail to " . $thisUser->fullName . " <" . $thisUser->username . "> failed to queue.");
							}
							
						}
						$thisCron->start_time = $next_run_date;
						$thisCron->last_run = $last_run_date;
						$this->Reminders->save($thisCron);
						$io->verbose("  -- FINISHED.");
						break;
					default:
						// Catch for unknown types.
						$io->warning("WARNING: UNIMPLEMENTED TYPE!!");
						break;
				}
			} else {
				// DO NOT run it.
				$io->verbose($verbose_string . " -- skipped.");
			}
		}
	}

}