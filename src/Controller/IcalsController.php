<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\I18n\Date;
use Sabre\VObject;
use Cake\Network\Exception\NotFoundException;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 *
 * @method \App\Model\Entity\Job[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IcalsController extends AppController
{
	/*
	                             .o.                       .   oooo        
	                            .888.                    .o8   `888        
	 ooo. .oo.    .ooooo.      .8"888.     oooo  oooo  .o888oo  888 .oo.   
	 `888P"Y88b  d88' `88b    .8' `888.    `888  `888    888    888P"Y88b  
	  888   888  888   888   .88ooo8888.    888   888    888    888   888  
	  888   888  888   888  .8'     `888.   888   888    888 .  888   888  
	 o888o o888o `Y8bod8P' o88o     o8888o  `V88V"V8P'   "888" o888o o888o 
	*/
	public function beforeFilter(\Cake\Event\Event $event)
	{
		$this->Auth->allow(['jobs', 'users', 'user']);
	}



	/*
	     o8o            .o8       
	     `"'           "888       
	    oooo  .ooooo.   888oooo.  
	    `888 d88' `88b  d88' `88b 
	     888 888   888  888   888 
	     888 888   888  888   888 
	     888 `Y8bod8P'  `Y8bod8P' 
	     888                      
	 .o. 88P                      
	 `Y888P                       
	*/
	public function jobs($key = null, $drop = null)
	{
		if ( is_null($key) || $key <> $this->CONFIG_DATA['calendar-api-key'] ) {
			throw new NotFoundException(__('Calendar key invalid'));
		}
		if ( is_null($drop) ) {
			return $this->redirect(["action" => "jobs", $key, "jobs.ics"]);
		}

		$this->loadModel("Jobs");
		
		$jobFind = $this->Jobs->find("all")
			->contain([
				"UsersScheduled",
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
			$thisKahuna['DESCRIPTION'] .= '\n\nTimes: ' . $job->time_string;
			$thisKahuna['DESCRIPTION'] .= '\n\nRequirements:\n';
			foreach ( $job->roles as $role ) {
				$thisKahuna['DESCRIPTION'] .= ' * ' . $role->title . '(' . $role->_joinData->number_needed . ')\n';
			}
			$thisKahuna['DESCRIPTION'] .= '\nStaffing:\n';
			$userlist = [];
			foreach ( $job->users_sch as $user ) {
				$userlist[$user->id] = $user->first . " " . $user->last;
			}
			foreach ( $userlist as $id => $name ) {
				$thisKahuna['DESCRIPTION'] .= ' * ' . $name . '\n';
			}
			$thisKahuna['DESCRIPTION'] .= '\nNotes:\n';
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


		$vcalendar = new VObject\Component\VCalendar();

		foreach ( $bigKahuna as $thisEvt ) {
			$vEvt = $vcalendar->add('VEVENT');

			$dtstart = $vEvt->add('DTSTART', $thisEvt['DTSTART']);
			$dtstart['VALUE'] = 'DATE';
			$vEvt->remove("UID");
			$vEvt->add('UID', $thisEvt['UID']);
			$vEvt->add('SUMMARY', $thisEvt['SUMMARY']);
			$vEvt->add('LOCATION', $thisEvt['LOCATION']);
			$vEvt->add('DESCRIPTION', preg_replace("/\\\\n/", "\n", $thisEvt['DESCRIPTION']));
		}

		$this->set('ical', $vcalendar->serialize());

		$this->response->type('ics');

		$this->viewBuilder()->setLayout('ics');
		$this->render("ics");
	}



	/*
	 oooo  oooo   .oooo.o  .ooooo.  oooo d8b  .oooo.o 
	 `888  `888  d88(  "8 d88' `88b `888""8P d88(  "8 
	  888   888  `"Y88b.  888ooo888  888     `"Y88b.  
	  888   888  o.  )88b 888    .o  888     o.  )88b 
	  `V88V"V8P' 8""888P' `Y8bod8P' d888b    8""888P' 
	*/
	public function users($key = null, $drop = null) {
		if ( is_null($key) || $key <> $this->CONFIG_DATA['calendar-api-key'] ) {
			throw new NotFoundException(__('Calendar key invalid'));
		}
		if ( is_null($drop) ) {
			return $this->redirect(["action" => "users", $key, "users.ics"]);
		}

		$this->loadModel("Jobs");
		
		$jobFind = $this->Jobs->find("all")
			->contain([
				"UsersScheduled",
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
			$thisKahuna['LOCATION'] = $job->location;
			$thisKahuna['DESCRIPTION'] = $job->category . ": " . $job->name;
			$thisKahuna['DESCRIPTION'] .= '\n\nTimes: ' . $job->time_string . '\n\n' . $job->detail;
			$thisKahuna['DESCRIPTION'] .= '\n\nNotes:\n';
			$thisKahuna['DESCRIPTION'] .= preg_replace("/\r\n/", "\\n", $job->notes);


			if ( $job->date_start == $job->date_end ) {
				$thisKahuna['DTSTART'] = $job->date_start->format("Ymd");
				$userlist = [];
				foreach ( $job->users_sch as $user ) {
					$userlist[$user->id] = $user->first . " " . $user->last;
				}
				foreach ( $userlist as $id => $name ) {
					$thisKahuna['SUMMARY'] = $name . " - " . $job->name;
					$thisKahuna['UID'] = $id . $job->id . "-" . $job->date_start->format("Y-m-d") . "@" . preg_replace("/ht.+?:\/\//", "", $this->CONFIG_DATA["server-name"]);
					$bigKahuna[] = $thisKahuna;
				}
				
			} else {
				$i = 0; // Safety net.
				for ( $thisDate = $job->date_start; $i < 10 && $thisDate < $job->date_end->addDay(1); $thisDate = $thisDate->addDay(1)) {
					$thisKahuna['DTSTART'] = $thisDate->format("Ymd");
					$i++;
					$userlist = [];
					foreach ( $job->users_sch as $user ) {
						$userlist[$user->id] = $user->first . " " . $user->last;
					}
					foreach ( $userlist as $id => $name ) {
						$thisKahuna['SUMMARY'] = $name . " - " . $job->name;
						$thisKahuna['UID'] = $id . $job->id . "-" . $thisDate->format("Y-m-d") . "@" . preg_replace("/ht.+?:\/\//", "", $this->CONFIG_DATA["server-name"]);
						$bigKahuna[] = $thisKahuna;
					}
				}
			}
		}

		$vcalendar = new VObject\Component\VCalendar();

		foreach ( $bigKahuna as $thisEvt ) {
			$vEvt = $vcalendar->add('VEVENT');

			$dtstart = $vEvt->add('DTSTART', $thisEvt['DTSTART']);
			$dtstart['VALUE'] = 'DATE';

			$vEvt->remove("UID");
			$vEvt->add('UID', $thisEvt['UID']);
			$vEvt->add('SUMMARY', $thisEvt['SUMMARY']);
			$vEvt->add('LOCATION', $thisEvt['LOCATION']);
			$vEvt->add('DESCRIPTION', preg_replace("/\\\\n/", "\n", $thisEvt['DESCRIPTION']));
		}

		$this->set('ical', $vcalendar->serialize());

		$this->response->type('ics');

		$this->viewBuilder()->setLayout('ics');
		$this->render("ics");
	}



	/*
	 oooo  oooo   .oooo.o  .ooooo.  oooo d8b 
	 `888  `888  d88(  "8 d88' `88b `888""8P 
	  888   888  `"Y88b.  888ooo888  888     
	  888   888  o.  )88b 888    .o  888     
	  `V88V"V8P' 8""888P' `Y8bod8P' d888b    
	*/
	public function user($userID = null, $key = null, $drop = null) {
		if ( is_null($userID) ) {
			throw new NotFoundException(__('User key invalid'));
		}
		if ( is_null($key) || $key <> $this->CONFIG_DATA['calendar-api-key'] ) {
			throw new NotFoundException(__('Calendar key invalid'));
		}
		if ( is_null($drop) ) {
			return $this->redirect(["action" => "user", $userID, $key, "user.ics"]);
		}

		$this->loadModel("Jobs");
		
		$jobFind = $this->Jobs->find("all")
			->contain([
				"UsersScheduled",
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
			$thisKahuna['SUMMARY'] = $job->catergory . ": " . $job->name;
			$thisKahuna['UID'] = $userID . $job->id . "-" . $job->date_start->format("Y-m-d") . "@" . preg_replace("/ht.+?:\/\//", "", $this->CONFIG_DATA["server-name"]);
			$thisKahuna['LOCATION'] = $job->location;
			$thisKahuna['DESCRIPTION'] = "You are scheduled for this event.";
			$thisKahuna['DESCRIPTION'] .= '\n\nTimes: ' . $job->time_string . '\n\n' . $job->detail;
			$thisKahuna['DESCRIPTION'] .= '\n\nNotes:\n';
			$thisKahuna['DESCRIPTION'] .= preg_replace("/\r\n/", "\\n", $job->notes);


			if ( $job->date_start == $job->date_end ) {
				$thisKahuna['DTSTART'] = $job->date_start->format("Ymd");
				$userlist = [];
				foreach ( $job->users_sch as $user ) {
					$userlist[$user->id] = $user->first . " " . $user->last;
				}
				if ( array_key_exists($userID, $userlist) ) {
					$bigKahuna[] = $thisKahuna;
				}
				
			} else {
				$i = 0; // Safety net.
				for ( $thisDate = $job->date_start; $i < 10 && $thisDate < $job->date_end->addDay(1); $thisDate = $thisDate->addDay(1)) {
					$thisKahuna['DTSTART'] = $thisDate->format("Ymd");
					$userlist = [];
					$i++;
					foreach ( $job->users_sch as $user ) {
						$userlist[$user->id] = $user->first . " " . $user->last;
					}
					if ( array_key_exists($userID, $userlist) ) {
						$bigKahuna[] = $thisKahuna;
					}
				}
			}
		}

		$vcalendar = new VObject\Component\VCalendar();

		foreach ( $bigKahuna as $thisEvt ) {
			$vEvt = $vcalendar->add('VEVENT');

			$dtstart = $vEvt->add('DTSTART', $thisEvt['DTSTART']);
			$dtstart['VALUE'] = 'DATE';

			$vEvt->remove("UID");
			$vEvt->add('UID', $thisEvt['UID']);
			$vEvt->add('SUMMARY', $thisEvt['SUMMARY']);
			$vEvt->add('LOCATION', $thisEvt['LOCATION']);
			$vEvt->add('DESCRIPTION', preg_replace("/\\\\n/", "\n", $thisEvt['DESCRIPTION']));
		}

		$this->set('ical', $vcalendar->serialize());

		$this->response->type('ics');

		$this->viewBuilder()->setLayout('ics');
		$this->render("ics");
	}
}