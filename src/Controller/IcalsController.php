<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\I18n\Date;
use Cake\Chronos\ChronosInterface;
use Cake\Chronos\Chronos;
use Cake\Mailer\Email;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 *
 * @method \App\Model\Entity\Job[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IcalsController extends AppController
{
	public function jobs()
	{
		$this->loadModel("Jobs");
		
		$jobFind = $this->Jobs->find("all")
			->contain([
				"UsersScheduled",// => [ "sort" => ["Users.last" => "ASC", "Users.first" => "ASC"]],
				"Roles" => [ "sort" => ["Roles.sort_order" => "ASC"]]
			])
			->order([
				'is_open'    => 'DESC',
				'is_active'  => 'DESC',
				'date_start' => 'DESC',
				'name'       => 'asc'
			]);

		$jobs = $jobFind;

		$bigKahuna = [];

		foreach ( $jobFind as $job ) {
			$thisKahuna = [];
			$thisKahuna['SUMMARY'] = $job->category . ": " . $job->name;
			$thisKahuna['LOCATION'] = $job->location;
			$thisKahuna['DESCRIPTION'] = $job->detail;
			$thisKahuna['DESCRIPTION'] .= '\n\nRequirements:\n';
			foreach ( $job->roles as $role ) {
				$thisKahuna['DESCRIPTION'] .= ' * ' . $role->title . '(' . $role->_joinData->number_needed . ')\n';
			}
			$thisKahuna['DESCRIPTION'] .= '\n\nStaffing:\n';
			$userlist = [];
			foreach ( $job->users_sch as $user ) {
				$userlist[$user->id] = $user->first . " " . $user->last;
			}
			foreach ( $userlist as $id => $name ) {
				$thisKahuna['DESCRIPTION'] .= ' * ' . $name . '\n';
			}
			$thisKahuna['DESCRIPTION'] .= '\n\Notes:\n';
			$thisKahuna['DESCRIPTION'] .= preg_replace("/\r\n/", "\\n", $job->notes);


			if ( $job->date_start == $job->date_end ) {
				$thisKahuna['DTSTART'] = $job->date_start->format("Ymd");
				$thisKahuna['UID'] = $job->id . "-" . $job->date_start->format("Y-m-d") . "@" . preg_replace("/ht.+?:\/\//", "", $this->CONFIG_DATA["server-name"]);

				$bigKahuna[] = $thisKahuna;
				
			} else {
				$i = 0; // Safety net.
				for ( $thisDate = $job->date_start; $i < 10 && $thisDate < $job->date_end->addDay(1); $thisDate = $thisDate->addDay(1)) {
					$thisKahuna['DTSTART'] = $thisDate->format("Ymd");
					$thisKahuna['UID'] = $job->id . "-" . $thisDate->format("Y-m-d") . "@" . preg_replace("/ht.+?:\/\//", "", $this->CONFIG_DATA["server-name"]);
					$i++;

					$bigKahuna[] = $thisKahuna;
				}
			}
		}

		$this->set(compact('jobs', 'bigKahuna'));
		$this->render("blank");
	}
}