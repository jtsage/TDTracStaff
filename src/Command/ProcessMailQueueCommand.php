<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\Email;

class ProcessMailQueueCommand extends Command
{
	protected function buildOptionParser(ConsoleOptionParser $parser)
	{
		$optName = "Active";
		$parser->setDescription("Process the current mail queue (100 max)");
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

		$this->loadModel("MailQueues");

		$mails = $this->MailQueues->find("all")->order(["created_at" => "ASC"])->limit(100);

		foreach ( $mails as $thisMail ) {
			try {
				$email = new Email('default');
				$email
					->setDomain(preg_replace("/htt.+?:\/\//", "", $configArr["server-name"]))
					->setTo($thisMail->toUser)
					->setSubject($thisMail->subject)
					->setViewVars(json_decode($thisMail->viewvars, true));
				$email->viewBuilder()->setTemplate($thisMail->template);
				$email->send($thisMail->body);
			} catch(SocketException $e) {
				$io->verbose("Mail failed " . $thisMail->toUser . " :: " . $thisMail->subject );
			} finally {
				$io->verbose("Mail sent " . $thisMail->toUser );
				if ($this->MailQueues->delete($thisMail)) {
					$io->verbose('Entry Removed');
				} else {
					$io->error("Failed to remove old entry. Bad.");
				}
			}
		}
	}
}