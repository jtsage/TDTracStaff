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
class JobsController extends AppController
{
	public $paginate = [
		'limit' => 10,
		'order' => [
			'is_open'    => 'DESC',
			'is_active'  => 'DESC',
			'date_start' => 'DESC',
			'name'       => 'asc'
		]
	];
	/*
	 ooooo                   .o8                        
	 `888'                  "888                        
	  888  ooo. .oo.    .oooo888   .ooooo.  oooo    ooo 
	  888  `888P"Y88b  d88' `888  d88' `88b  `88b..8P'  
	  888   888   888  888   888  888ooo888    Y888'    
	  888   888   888  888   888  888    .o  .o8"'88b   
	 o888o o888o o888o `Y8bod88P" `Y8bod8P' o88'   888o 
	*/
	public function index()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("Open Jobs")]
		]);

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where(["is_open" => 1 ]);

		$jobs = $this->paginate($jobFind);

		$this->loadModel("Payrolls");

		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$this->set(compact('jobs'));
	}



	/*
	          oooo                               .   
	          `888                             .o8   
	  .oooo.o  888 .oo.    .ooooo.  oooo d8b .o888oo 
	 d88(  "8  888P"Y88b  d88' `88b `888""8P   888   
	 `"Y88b.   888   888  888   888  888       888   
	 o.  )88b  888   888  888   888  888       888 . 
	 8""888P' o888o o888o `Y8bod8P' d888b      "888" 
	*/
	public function short()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("All Jobs")]
		]);

		$jobFind = $this->Jobs->find("all")
			->order([
				'is_open'    => 'DESC',
				'is_active'  => 'DESC',
				'date_start' => 'DESC',
				'name'       => 'asc'
			]);

		$jobs = $jobFind;

		

		$this->set(compact('jobs'));
	}



	/*
	  o8o                                      .   
	  `"'                                    .o8   
	 oooo  ooo. .oo.    .oooo.    .ooooo.  .o888oo 
	 `888  `888P"Y88b  `P  )88b  d88' `"Y8   888   
	  888   888   888   .oP"888  888         888   
	  888   888   888  d8(  888  888   .o8   888 . 
	 o888o o888o o888o `Y888""8o `Y8bod8P'   "888" 
	*/
	public function inact()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("Closed Jobs")]
		]);

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where(["is_open" => 1, "is_active" => 0 ]);

		$jobs = $this->paginate($jobFind);

		$this->loadModel("Payrolls");

		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$this->set("subtitle", "Open and Inactive");
		$this->set("subtext", "This display shows those only inactive, but still open jobs");
		$this->set(compact('jobs'));
		$this->render("index");
	}



	/*
	           oooo                                     .o8  
	           `888                                    "888  
	  .ooooo.   888   .ooooo.   .oooo.o  .ooooo.   .oooo888  
	 d88' `"Y8  888  d88' `88b d88(  "8 d88' `88b d88' `888  
	 888        888  888   888 `"Y88b.  888ooo888 888   888  
	 888   .o8  888  888   888 o.  )88b 888    .o 888   888  
	 `Y8bod8P' o888o `Y8bod8P' 8""888P' `Y8bod8P' `Y8bod88P" 
	*/
	public function closed()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("Closed Jobs")]
		]);

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where(["is_open" => 0 ]);

		$jobs = $this->paginate($jobFind);

		$this->loadModel("Payrolls");

		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$this->set("subtitle", "Closed");
		$this->set("subtext", "This display shows those only closed jobs");
		$this->set(compact('jobs'));
		$this->render("index");
	}



	/*
	                                  oooo            .o8                
	                                  `888           "888                
	 ooo. .oo.  .oo.   oooo    ooo     888  .ooooo.   888oooo.   .oooo.o 
	 `888P"Y88bP"Y88b   `88.  .8'      888 d88' `88b  d88' `88b d88(  "8 
	  888   888   888    `88..8'       888 888   888  888   888 `"Y88b.  
	  888   888   888     `888'        888 888   888  888   888 o.  )88b 
	 o888o o888o o888o     .8'     .o. 88P `Y8bod8P'  `Y8bod8P' 8""888P' 
	                   .o..P'      `Y888P                                
	                   `Y8P'                                             
	*/
	public function myjobs()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("My Qualified Jobs")]
		]);

		$jobFind = $this->Jobs->find("detailSubset", [
			"userID"    => $this->Auth->user("id"),
			"limitList" => $this->loadModel("JobsRoles")->find("mine", ["userID" => $this->Auth->user("id")])
		]);

		$this->loadModel("Payrolls");
		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$jobs = $this->paginate($jobFind);

		$this->set("subtitle", "Qualified For");
		$this->set("subtext", "This display shows those jobs that you have the required training for - please make sure to indicate your availability if you have not already.");
		$this->set(compact('jobs'));
		$this->render("index");
	}


	/*
	                                                  oooo                        .o8  
	                                                  `888                       "888  
	 ooo. .oo.  .oo.   oooo    ooo  .oooo.o  .ooooo.   888 .oo.    .ooooo.   .oooo888  
	 `888P"Y88bP"Y88b   `88.  .8'  d88(  "8 d88' `"Y8  888P"Y88b  d88' `88b d88' `888  
	  888   888   888    `88..8'   `"Y88b.  888        888   888  888ooo888 888   888  
	  888   888   888     `888'    o.  )88b 888   .o8  888   888  888    .o 888   888  
	 o888o o888o o888o     .8'     8""888P' `Y8bod8P' o888o o888o `Y8bod8P' `Y8bod88P" 
	                   .o..P'                                                          
	                   `Y8P'                                                           
	*/
	public function mysched()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("My Scheduled Jobs")]
		]);

		$jobFind = $this->Jobs->find("detailSubset", [
			"userID"    => $this->Auth->user("id"),
			"limitList" => $this->loadModel("UsersJobs")->find("mine", [
				"userID"      =>  $this->Auth->user("id"),
				"true_filter" => "is_scheduled"
			])
		]);
	
		$this->loadModel("Payrolls");
		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$jobs = $this->paginate($jobFind);

		$this->set("subtitle", "Scheduled For");
		$this->set("subtext", "This display shows those jobs that you have been scheduled to work, as approved by the administrator(s).");
		$this->set(compact('jobs'));
		$this->render("index");
	}


	/*
	 ooo. .oo.  .oo.   oooo    ooo oooo d8b  .ooooo.   .oooo.o oo.ooooo.  
	 `888P"Y88bP"Y88b   `88.  .8'  `888""8P d88' `88b d88(  "8  888' `88b 
	  888   888   888    `88..8'    888     888ooo888 `"Y88b.   888   888 
	  888   888   888     `888'     888     888    .o o.  )88b  888   888 
	 o888o o888o o888o     .8'     d888b    `Y8bod8P' 8""888P'  888bod8P' 
	                   .o..P'                                   888       
	                   `Y8P'                                   o888o      
	*/
	function myrespond()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("My Scheduled Jobs")]
		]);

		$this->loadModel('UsersJobs');
		$this->loadModel('JobsRoles');
		$this->loadModel('UsersRoles');

		$mySched = $this->UsersJobs->find("all")
			->select(["job_id"])
			->where([
				"user_id" => $this->Auth->User("id"),
			])
			->group(["job_id"]);

		$myNoResp = $this->JobsRoles->find("all")
			->contain(["Jobs"])
			->select(["job_id"])
			->group(["job_id"])
			->where([
				"role_id IN" => $this->UsersRoles->find("all")->select(["role_id"])->where(["user_id" => $this->Auth->User("id")]),
				"Jobs.is_active" => 1,
				"job_id NOT IN" => $mySched
			]);
		$this->set("myNoResp", $myNoResp->toArray());

		$jobFind = $this->Jobs->find("detailSubset", [
			"userID"    => $this->Auth->user("id"),
			"limitList" => $myNoResp
		]);
	
		$this->loadModel("Payrolls");
		$this->set("myTotals", $this->Payrolls->find('jobTotals')->where(["user_id"=>$this->Auth->user("id")])->indexBy('job_id')->toArray());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id')->toArray());

		$jobs = $this->paginate($jobFind);

		$this->set("subtitle", "Awaiting Response");
		$this->set("subtext", "This display shows those shows that you have not yet responded with your availability.");
		$this->set(compact('jobs'));
		$this->render("index");
	}

	/*
	              o8o                             
	              `"'                             
	 oooo    ooo oooo   .ooooo.  oooo oooo    ooo 
	  `88.  .8'  `888  d88' `88b  `88. `88.  .8'  
	   `88..8'    888  888ooo888   `88..]88..8'   
	    `888'     888  888    .o    `888'`888'    
	     `8'     o888o `Y8bod8P'     `8'  `8'     
	*/
	public function view($id = null)
	{
		$job = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where([
				"id" => $id
			]);

		$job1 = $job->first();
		$this->loadModel("UsersJobs");

		$yourStat = $this->UsersJobs->find("all")
			->where([
				"user_id" => $this->Auth->user("id"),
				"job_id" => $job1->id
			]);

		$this->loadModel("Payrolls");

		$this->set("userTotals", $this->Payrolls->find('userTotals')->where(["job_id"=>$job1->id,"user_id"=>$this->Auth->user("id")])->first());
		$this->set("jobTotals", $this->Payrolls->find('jobTotals')->where(["job_id"=>$job1->id])->first());

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, $job1->name]
		]);

		$budgeTotal = $this->loadModel("Budgets")->find("totalList");
		$this->set("budgeTotal", $budgeTotal->toArray());

		$this->set('yourStat', $yourStat->first());
		$this->set('job', $job1);
	}

	


	/*
	              .              .o88o.  .o88o. ooooo      ooo                           .o8  
	            .o8              888 `"  888 `" `888b.     `8'                          "888  
	  .oooo.o .o888oo  .oooo.   o888oo  o888oo   8 `88b.    8   .ooooo.   .ooooo.   .oooo888  
	 d88(  "8   888   `P  )88b   888     888     8   `88b.  8  d88' `88b d88' `88b d88' `888  
	 `"Y88b.    888    .oP"888   888     888     8     `88b.8  888ooo888 888ooo888 888   888  
	 o.  )88b   888 . d8(  888   888     888     8       `888  888    .o 888    .o 888   888  
	 8""888P'   "888" `Y888""8o o888o   o888o   o8o        `8  `Y8bod8P' `Y8bod8P' `Y8bod88P" 
	*/
	public function staffNeed($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		if ( !$this->request->is(['patch','post','put'])) {
			$job = $this->Jobs->get($id);

			$this->loadModel("Roles");
			$this->loadModel("JobsRoles");

			$needed = $this->JobsRoles->find("all")->where(["job_id" => $id]);

			$roles = $this->Roles->find("all")->order(["sort_order" => "ASC"]);

			$this->set('needed', $needed);
			$this->set('roles', $roles);
			$this->set('job', $job);

			$this->set('crumby', [
				["/", __("Dashboard")],
				["/jobs/", __("Jobs")],
				["/jobs/view/" . $job->id, $job->name],
				[null, __("Edit Staffing Needs")]
			]);
		} else {
			$inserts = [];
			foreach ( $this->request->getData() as $formID => $value ) {
				if ( !empty($value) && $value > 0 ) {
					$inserts[] = [
						'job_id'        => $id,
						'role_id'       => $formID,
						'number_needed' => $value
					];
				}
			}
			$this->loadModel("JobsRoles");

			$this->JobsRoles->deleteAll([
				"job_id" => $id
			]);

			$entities = $this->JobsRoles->newEntities($inserts);
			$results = $this->JobsRoles->saveMany($entities);
			$this->Flash->success("Staff requirements updated");
			return $this->redirect(["action" => "view", $id]);
		}
	}

	/*
	                 .o8        .o8  
	                "888       "888  
	  .oooo.    .oooo888   .oooo888  
	 `P  )88b  d88' `888  d88' `888  
	  .oP"888  888   888  888   888  
	 d8(  888  888   888  888   888  
	 `Y888""8o `Y8bod88P" `Y8bod88P" 
	*/
	public function add()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$allCats = $this->Jobs->find()
			->distinct(['category'])
			->select(['category'])
			->order(["category" => "ASC"]);
		$allLoc = $this->Jobs->find()
			->distinct(['location'])
			->select(['location'])
			->order(["location" => "ASC"]);

		$this->set(compact('allCats','allLoc'));

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("Add New Jobs")]
		]);

		$job = $this->Jobs->newEntity();
		if ($this->request->is('post')) {
			$job = $this->Jobs->patchEntity($job, $this->request->getData());
			if ($this->Jobs->save($job)) {
				$this->Flash->success(__('The job has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The job could not be saved. Please, try again.'));
		}
		$this->set(compact('job'));
	}

	/*
	                 .o8   o8o      .   
	                "888   `"'    .o8   
	  .ooooo.   .oooo888  oooo  .o888oo 
	 d88' `88b d88' `888  `888    888   
	 888ooo888 888   888   888    888   
	 888    .o 888   888   888    888 . 
	 `Y8bod8P' `Y8bod88P" o888o   "888" 
	*/
	public function edit($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$allCats = $this->Jobs->find()
			->distinct(['category'])
			->select(['category'])
			->order(["category" => "ASC"]);
		$allLoc = $this->Jobs->find()
			->distinct(['location'])
			->select(['location'])
			->order(["location" => "ASC"]);

		$this->set(compact('allCats','allLoc'));

		$job = $this->Jobs->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$job = $this->Jobs->patchEntity($job, $this->request->getData());
			if ($this->Jobs->save($job)) {
				$this->Flash->success(__('The job has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The job could not be saved. Please, try again.'));
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/view/" . $job->id, $job->name],
			[null, __("Edit Job")]
		]);

		$this->set(compact('job'));
	}


	/*
	       .o8            oooo                .             
	      "888            `888              .o8             
	  .oooo888   .ooooo.   888   .ooooo.  .o888oo  .ooooo.  
	 d88' `888  d88' `88b  888  d88' `88b   888   d88' `88b 
	 888   888  888ooo888  888  888ooo888   888   888ooo888 
	 888   888  888    .o  888  888    .o   888 . 888    .o 
	 `Y8bod88P" `Y8bod8P' o888o `Y8bod8P'   "888" `Y8bod8P' 
	*/
	public function delete($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		
		$job = $this->Jobs->get($id);
		if ($this->Jobs->delete($job)) {
			$this->Flash->success(__('The job has been deleted.'));
		} else {
			$this->Flash->error(__('The job could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}


	/*
	                                  o8o  oooo             .o8       oooo            
	                                  `"'  `888            "888       `888            
	  .oooo.   oooo    ooo  .oooo.   oooo   888   .oooo.    888oooo.   888   .ooooo.  
	 `P  )88b   `88.  .8'  `P  )88b  `888   888  `P  )88b   d88' `88b  888  d88' `88b 
	  .oP"888    `88..8'    .oP"888   888   888   .oP"888   888   888  888  888ooo888 
	 d8(  888     `888'    d8(  888   888   888  d8(  888   888   888  888  888    .o 
	 `Y888""8o     `8'     `Y888""8o o888o o888o `Y888""8o  `Y8bod8P' o888o `Y8bod8P' 
	*/
	public function available($id = null)
	{
		$job = $this->Jobs->get($id, [
			'contain' => ['Roles']
		]);

		$this->loadModel("UsersRoles");
		$this->loadModel("UsersJobs");

		$assigned = $this->UsersJobs->find("all")
			->where([
				"job_id" => $id,
				"user_id" => $this->Auth->user("id")
			]);

		$trained = $this->UsersRoles->find("all")
			->where([
				"user_id" => $this->Auth->user("id")
			]);

		$canDo = [];
		foreach ( $trained as $role ) {
			$canDo[] = $role->role_id;
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/view/" . $job->id, $job->name],
			[null, "Your Availability"]
		]);

		$this->set("assigned", $assigned);
		$this->set("trained", $canDo);
		$this->set('job', $job);
	}



	/*
	              .              .o88o.  .o88o.       .o.                          o8o                         
	            .o8              888 `"  888 `"      .888.                         `"'                         
	  .oooo.o .o888oo  .oooo.   o888oo  o888oo      .8"888.      .oooo.o  .oooo.o oooo   .oooooooo ooo. .oo.   
	 d88(  "8   888   `P  )88b   888     888       .8' `888.    d88(  "8 d88(  "8 `888  888' `88b  `888P"Y88b  
	 `"Y88b.    888    .oP"888   888     888      .88ooo8888.   `"Y88b.  `"Y88b.   888  888   888   888   888  
	 o.  )88b   888 . d8(  888   888     888     .8'     `888.  o.  )88b o.  )88b  888  `88bod8P'   888   888  
	 8""888P'   "888" `Y888""8o o888o   o888o   o88o     o8888o 8""888P' 8""888P' o888o `8oooooo.  o888o o888o 
	                                                                                    d"     YD              
	                                                                                    "Y88888P'              
	*/
	function staffAssign( $id = null )
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		
		$job = $this->Jobs->get($id, [
			'contain' => [ 
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				]
			]
		]);

		$this->loadModel("UsersJobs");

		$interested = $this->UsersJobs->find("all")
			->contain(["Users"])
			->order([
				"Users.last"  => "ASC",
				"Users.first" => "ASC"
			])
			->where([
				"job_id"       => $id,
				"is_available" => 1
			]);

		$this->set("job", $job);
		$this->set("interest", $interested);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/view/" . $job->id, $job->name],
			[null, "Assigned Staff"]
		]);
	}

	/*
	  .o88o.                                              .o.                          o8o                         
	  888 `"                                             .888.                         `"'                         
	 o888oo   .ooooo.  oooo d8b  .ooooo.   .ooooo.      .8"888.      .oooo.o  .oooo.o oooo   .oooooooo ooo. .oo.   
	  888    d88' `88b `888""8P d88' `"Y8 d88' `88b    .8' `888.    d88(  "8 d88(  "8 `888  888' `88b  `888P"Y88b  
	  888    888   888  888     888       888ooo888   .88ooo8888.   `"Y88b.  `"Y88b.   888  888   888   888   888  
	  888    888   888  888     888   .o8 888    .o  .8'     `888.  o.  )88b o.  )88b  888  `88bod8P'   888   888  
	 o888o   `Y8bod8P' d888b    `Y8bod8P' `Y8bod8P' o88o     o8888o 8""888P' 8""888P' o888o `8oooooo.  o888o o888o 
	                                                                                        d"     YD              
	                                                                                        "Y88888P'              
	*/
	function forceStaffAssign( $id = null )
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		
		$job = $this->Jobs->get($id, [
			'contain' => [ 
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				]
			]
		]);

		$this->loadModel("UsersJobs");
		$this->loadModel("UsersRoles");

		$allRoles = $this->UsersRoles->find("all")
			->contain(["Users" => ["fields" => ["id", "is_active", "last", "first"]]])
			->where(["Users.is_active" => 1])
			->order(["Users.last" => "ASC", "Users.first" => "ASC"]);

		$this->set("userRoles", $allRoles);

		$interested = $this->UsersJobs->find("all")
			->contain(["Users"])
			->order([
				"Users.last"  => "ASC",
				"Users.first" => "ASC"
			])
			->where([
				"job_id"       => $id
			]);

		$this->set("job", $job);
		$this->set("interest", $interested);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/view/" . $job->id, $job->name],
			[null, "FORCE Assigned Staff"]
		]);
	}



	/*
	                      o8o                  .   
	                      `"'                .o8   
	 oo.ooooo.  oooo d8b oooo  ooo. .oo.   .o888oo 
	  888' `88b `888""8P `888  `888P"Y88b    888   
	  888   888  888      888   888   888    888   
	  888   888  888      888   888   888    888 . 
	  888bod8P' d888b    o888o o888o o888o   "888" 
	  888                                          
	 o888o                                         
	*/
	function print( $id = null )
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		
		$job = $this->Jobs->get($id, [
			'contain' => [ 
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				]
			]
		]);

		$this->loadModel("UsersJobs");

		$interested = $this->UsersJobs->find("all")
			->contain(["Users"])
			->order([
				"Users.last"  => "ASC",
				"Users.first" => "ASC"
			])
			->where([
				"job_id"       => $id,
				"is_scheduled" => 1
			]);

		$this->set("job", $job);
		$this->set("interest", $interested);

		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setLayout('default');
		$title = "Scheduled Job Staff - " . $job->name;
		$this->set('pdfTitle', $title);
		$this->viewBuilder()->options([
			'pdfConfig' => [
				'download' => false,
				'title' => $title
			]
		]);
		$this->response->header('Content-Disposition: inline;filename="' . preg_replace("/ /", "_", preg_replace("/ - /", "-", $title)) . ".pdf\"");
	}



	/*
	                    oooo                        .o8   .oooooo..o               .   
	                    `888                       "888  d8P'    `Y8             .o8   
	  .oooo.o  .ooooo.   888 .oo.    .ooooo.   .oooo888  Y88bo.       .ooooo.  .o888oo 
	 d88(  "8 d88' `"Y8  888P"Y88b  d88' `88b d88' `888   `"Y8888o.  d88' `88b   888   
	 `"Y88b.  888        888   888  888ooo888 888   888       `"Y88b 888ooo888   888   
	 o.  )88b 888   .o8  888   888  888    .o 888   888  oo     .d8P 888    .o   888 . 
	 8""888P' `Y8bod8P' o888o o888o `Y8bod8P' `Y8bod88P" 8""88888P'  `Y8bod8P'   "888" 
	*/
	function schedSet ($intId = null, $value = null, $redir = 0 )
	{
		if ( is_null($intId) || is_null($value) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'index']);
		}
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->get($intId);

		$jobRec->is_scheduled = $value;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Schedule Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		return $this->redirect(['action' => (($redir)?'forceStaffAssign':'staffAssign'), $jobRec->job_id]);
	}



	/*
	                                              .o.                              o8o  oooo  
	                                             .888.                             `"'  `888  
	 ooo. .oo.    .ooooo.  oooo oooo    ooo     .8"888.     oooo    ooo  .oooo.   oooo   888  
	 `888P"Y88b  d88' `88b  `88. `88.  .8'     .8' `888.     `88.  .8'  `P  )88b  `888   888  
	  888   888  888ooo888   `88..]88..8'     .88ooo8888.     `88..8'    .oP"888   888   888  
	  888   888  888    .o    `888'`888'     .8'     `888.     `888'    d8(  888   888   888  
	 o888o o888o `Y8bod8P'     `8'  `8'     o88o     o8888o     `8'     `Y888""8o o888o o888o 
	*/
	function newAvail($jobId = null, $roleId = null, $avail = null) {
		if ( is_null($jobId) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'myjobs']);
		}
		if ( is_null($avail) || is_null($roleId) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'available', $jobId]);
		}
		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->newEntity();

		$jobRec->user_id      = $this->Auth->user("id");
		$jobRec->role_id      = $roleId;
		$jobRec->job_id       = $jobId;
		$jobRec->is_available = $avail;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Availability Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		return $this->redirect(['action' => 'available', $jobId]);
	}



	/*
	  .o88o.                                         .oooooo..o               .   
	  888 `"                                        d8P'    `Y8             .o8   
	 o888oo   .ooooo.  oooo d8b  .ooooo.   .ooooo.  Y88bo.       .ooooo.  .o888oo 
	  888    d88' `88b `888""8P d88' `"Y8 d88' `88b  `"Y8888o.  d88' `88b   888   
	  888    888   888  888     888       888ooo888      `"Y88b 888ooo888   888   
	  888    888   888  888     888   .o8 888    .o oo     .d8P 888    .o   888 . 
	 o888o   `Y8bod8P' d888b    `Y8bod8P' `Y8bod8P' 8""88888P'  `Y8bod8P'   "888" 
	*/
	function forceSchedSet($jobId = null, $roleId = null, $userId = null, $sched = 0) {
		if ( is_null($jobId) || is_null($userId) || is_null($roleId) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'available', $jobId]);
		}

		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->newEntity();

		$jobRec->user_id      = $userId;
		$jobRec->role_id      = $roleId;
		$jobRec->job_id       = $jobId;
		$jobRec->is_available = 1;
		$jobRec->is_scheduled = $sched;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Schedule Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		return $this->redirect(['action' => 'forceStaffAssign', $jobId]);
	}



	/*
	           oooo                                     .o.                              o8o  oooo  
	           `888                                    .888.                             `"'  `888  
	  .ooooo.   888 .oo.   ooo. .oo.    .oooooooo     .8"888.     oooo    ooo  .oooo.   oooo   888  
	 d88' `"Y8  888P"Y88b  `888P"Y88b  888' `88b     .8' `888.     `88.  .8'  `P  )88b  `888   888  
	 888        888   888   888   888  888   888    .88ooo8888.     `88..8'    .oP"888   888   888  
	 888   .o8  888   888   888   888  `88bod8P'   .8'     `888.     `888'    d8(  888   888   888  
	 `Y8bod8P' o888o o888o o888o o888o `8oooooo.  o88o     o8888o     `8'     `Y888""8o o888o o888o 
	                                   d"     YD                                                    
	                                   "Y88888P'                                                    
	*/
	function changeAvail($jobId = null, $roleId = null, $avail = null) {
		if ( is_null($jobId) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'myjobs']);
		}
		if ( is_null($avail) || is_null($roleId) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'available', $jobId]);
		}
		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->find("all")
			->where([
				"job_id"  => $jobId,
				"role_id" => $roleId,
				"user_id" => $this->Auth->user("id")
			])
			->first();

		$jobRec->is_available = $avail;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Availability Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		return $this->redirect(['action' => 'available', $jobId]);
	}



	/*
	                     oooo                              .o8                     
	                     `888                             "888                     
	  .ooooo.   .oooo.    888   .ooooo.  ooo. .oo.    .oooo888   .oooo.   oooo d8b 
	 d88' `"Y8 `P  )88b   888  d88' `88b `888P"Y88b  d88' `888  `P  )88b  `888""8P 
	 888        .oP"888   888  888ooo888  888   888  888   888   .oP"888   888     
	 888   .o8 d8(  888   888  888    .o  888   888  888   888  d8(  888   888     
	 `Y8bod8P' `Y888""8o o888o `Y8bod8P' o888o o888o `Y8bod88P" `Y888""8o d888b    
	*/
	public function calendar ( $year = null, $month = null )
	{
		if ( is_null($year) && is_null($month) ) {
			$year = date("Y");
			$month = date("m");
		}

		$dateView = [];

		$dateView["nextLink"] = "/jobs/calendar/" . (( $month == 12 ) ? $year+1 : $year) . "/" . (( $month == 12 ) ? 1 : $month+1) . "/";
		$dateView["prevLink"] = "/jobs/calendar/" . (( $month == 1 ) ? $year-1 : $year) . "/" . (( $month == 1 ) ? 12 : $month-1) . "/";

		$calViewSrt  = new Date($year . "-" . $month . "-" . 1);
		$calViewEnd  = new Date($year . "-" . $month . "-" . 1);
		$calViewInfo = new Date($year . "-" . $month . "-" . 1);

		$calViewSrt->setWeekEndsAt(6);
		$calViewSrt->setWeekStartsAt(7);
		$calViewSrt = $calViewSrt->startOfWeek();

		$calViewEnd->setWeekEndsAt(6);
		$calViewEnd->setWeekStartsAt(7);
		$calViewEnd = $calViewEnd->addMonth(1)->subDays(1);
		$calViewEnd = $calViewEnd->endOfWeek();

		$weeksToShow = ($calViewSrt->diffInDays($calViewEnd) + 1) / 7;

		$currentDate = $calViewSrt;

		$calData = [];

		$jobs = $this->Jobs->find("all")
			->contain([
				"UsersBoth" => function (Query $q) {
					return $q->where(['UsersJobs.user_id' => $this->Auth->user("id")]);
				}
			])
			->where([
				"is_active" => 1,
				"is_open" => 1,
				"OR" => [
					[
						"date_start >" => $calViewSrt,
						"date_start <" => $calViewEnd
					], [
						"date_end >" => $calViewSrt,
						"date_end <" => $calViewEnd
					] 
				]
			])
			->order(["name" => "ASC"]);

		$maxSize = 2;

		for ( $cWeek = 1; $cWeek <= $weeksToShow; $cWeek++ ) {
			$weekData = [];
			for ( $cDay = 1; $cDay < 8; $cDay++ ) {
				$eventsThisDay = [];
				$OisInt = false;
				$OisSch = false;
				$thisSize = 0;

				foreach ( $jobs as $job ) {
					if ( $currentDate->between($job->date_start, $job->date_end) ) {
						$isInt = false;
						$isSch = false;
						$thisSize++;

						foreach ( $job->users_both as $stats ) {
							if ( $stats->_joinData->is_available ) { $isInt = true; $OisInt = true; }
							if ( $stats->_joinData->is_scheduled ) { $isSch = true; $OisSch = true; }
						}

						$eventsThisDay[] = [
							"id"       => $job->id,
							"name"     => $job->name,
							"status"   => ( ($isSch) ? 2 : ( ($isInt) ? 1 : 0 ) )
						];
					}
				}
				$weekData[] = [
					'date'      => $currentDate->format("Y-m-d"),
					'day'       => $currentDate->format("j"),
					'events'    => $eventsThisDay,
					'thisMonth' => ($currentDate->format("n") == $month),
					'ovrStatus' => ( ($OisSch) ? 2 : ( ($OisInt) ? 1 : 0 ) )
				];
				$currentDate = $currentDate->addDay();
				if ( $thisSize > $maxSize ) { $maxSize = $thisSize; }
			}
			$calData[] = $weekData;
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/calendar/", "Calendar"],
			[null, $calViewInfo->format("F Y")]
		]);
		$this->set('maxSize', $maxSize);
		$this->set('calViewInfo', $calViewInfo);
		$this->set('calData', $calData);
		$this->set('dateView', $dateView);
	}


	/*
	       .o8                        
	      "888                        
	  .oooo888   .oooo.   oooo    ooo 
	 d88' `888  `P  )88b   `88.  .8'  
	 888   888   .oP"888    `88..8'   
	 888   888  d8(  888     `888'    
	 `Y8bod88P" `Y888""8o     .8'     
	                      .o..P'      
	                      `Y8P'       
	*/
	public function day ( $date = null )
	{
		if ( is_null($date) ) {
			$date = date("Y-m-d");
		}

		$realDate = new Date($date);

		$nextDate = new Date($date);
		$nextDate = $nextDate->addDay(1);
		$prevDate = new Date($date);
		$prevDate = $prevDate->subDay(1);

		$dateView = [];

		$dateView["nextLink"] = "/jobs/day/" . $nextDate->format("Y-m-d");
		$dateView["prevLink"] = "/jobs/day/" . $prevDate->format("Y-m-d");

		$calData = [];

		$jobs = $this->Jobs->find("all")
			->contain([
				"UsersBoth" => function (Query $q) {
					return $q->where(['UsersJobs.user_id' => $this->Auth->user("id")]);
				}
			])
			->where([
				"is_active" => 1,
				"is_open" => 1,
				"date_start <=" => $realDate,
				"date_end >=" => $realDate
			])
			->order(["name" => "ASC"]);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/calendar/" . $realDate->format("Y") . "/" . $realDate->format("n"), "Calendar"],
			[null, $realDate->format("M j, Y")]
		]);
		$this->set('jobs', $jobs);
		$this->set('date', $realDate);
		$this->set('dateView', $dateView);
	}



	/*
	                                        o8o  oooo  
	                                        `"'  `888  
	  .ooooo.  ooo. .oo.  .oo.    .oooo.   oooo   888  
	 d88' `88b `888P"Y88bP"Y88b  `P  )88b  `888   888  
	 888ooo888  888   888   888   .oP"888   888   888  
	 888    .o  888   888   888  d8(  888   888   888  
	 `Y8bod8P' o888o o888o o888o `Y888""8o o888o o888o 
	*/
	public function email($id)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$this->loadComponent('Markdown.Markdown');

		$job = $this->Jobs->get($id);

		$jobArray = $job->toArray();
		
		foreach ( $jobArray as $key => $value ) {
			if ( gettype($value) == "object" ) {
				if ( get_class($value) == "Cake\I18n\FrozenDate" ) {
					$jobArray[$key . "_string"] = $value->format("l, F j, Y");
				}
			}
		}

		$this->loadModel("UsersRoles");
		$this->loadModel("JobsRoles");

		$roles = $this->JobsRoles->find("all")
			->select("role_id")
			->where(["job_id" => $id]);

		$users = $this->UsersRoles->find("all")
			->distinct(["user_id"])
			->contain(["Users"])
			->where(["role_id IN" => $roles]);

		$mailList = [];

		foreach ( $users as $user ) {
			if ( $user->user->is_active ) {
				$mailList[] = [ $user->user->username, $user->user->first . " " . $user->user->last ];
			}
		}

		$CONFIG = $this->CONFIG_DATA;

		$mailText = ( $job->created_at->wasWithinLast('2 days') ) ?
			$CONFIG['job-new-email'] :
			$CONFIG['job-old-email'];

		$mailText = preg_replace_callback(
			"/{{([\w-]+)}}/m",
			function ($matches) use ( $CONFIG ) {
				if ( !empty($CONFIG[$matches[1]]) ) {
					return $CONFIG[$matches[1]];
				}
				return $matches[1];
			},
			$mailText
		);
		$mailText = preg_replace_callback(
			"/\[\[([\w-]+)\]\]/m",
			function ($matches) use ( $jobArray ) {
				if ( !empty($jobArray[$matches[1]]) ) {
					return $jobArray[$matches[1]];
				}
				return $matches[1];
			},
			$mailText
		);

		$mailHTML = $this->Markdown->parse($mailText);

		$totalSent = 0;

		foreach ( $mailList as $location ) {
			$email = new Email('default');
			$email
				->template('default')
				->setTo(rtrim($location[0]), $location[1])
				->setSubject("A job requires staffing - " . $job->name)
				->setViewVars(['CONFIG' => $CONFIG]);
			$email->send($mailHTML);
			$totalSent++;
		}

		$this->Flash->success($totalSent . " Messages sent.");
		return $this->redirect(['action' => 'view', $id]);
	}



	/*
	                           .    o8o   .o88o.             
	                         .o8    `"'   888 `"             
	 ooo. .oo.    .ooooo.  .o888oo oooo  o888oo  oooo    ooo 
	 `888P"Y88b  d88' `88b   888   `888   888     `88.  .8'  
	  888   888  888   888   888    888   888      `88..8'   
	  888   888  888   888   888 .  888   888       `888'    
	 o888o o888o `Y8bod8P'   "888" o888o o888o       .8'     
	                                             .o..P'      
	                                             `Y8P'       
	*/
	function notify ($id = null )
	{
		if ( is_null($id) ) {
			$this->Flash->error(__('Invalid Action'));
			return $this->redirect(['action' => 'index']);
		}
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$this->loadComponent('Markdown.Markdown');

		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->get($id, [ "contain" => ["Jobs", "Users"]]);

		$jobArray = $jobRec->job->toArray();

		foreach ( $jobArray as $key => $value ) {
			if ( gettype($value) == "object" ) {
				if ( get_class($value) == "Cake\I18n\FrozenDate" ) {
					$jobArray[$key . "_string"] = $value->format("l, F j, Y");
				}
			}
		}

		$CONFIG = $this->CONFIG_DATA;

		$mailText = $CONFIG['notify-email'];

		$mailText = preg_replace_callback(
			"/{{([\w-]+)}}/m",
			function ($matches) use ( $CONFIG ) {
				if ( !empty($CONFIG[$matches[1]]) ) {
					return $CONFIG[$matches[1]];
				}
				return $matches[1];
			},
			$mailText
		);
		$mailText = preg_replace_callback(
			"/\[\[([\w-]+)\]\]/m",
			function ($matches) use ( $jobArray ) {
				if ( !empty($jobArray[$matches[1]]) ) {
					return $jobArray[$matches[1]];
				}
				return $matches[1];
			},
			$mailText
		);

		$mailHTML = $this->Markdown->parse($mailText);

		$email = new Email('default');
		$email
			->template('default')
			->setTo(rtrim($jobRec->user->username), $jobRec->user->first . " " . $jobRec->user->last)
			->setSubject("A job now has staffing - " . $jobRec->job->name . "-" . date("Y-m-d"))
			->setViewVars(['CONFIG' => $CONFIG]);
		$email->send($mailHTML);

		$this->Flash->success("Mail sent to " . $jobRec->user->first . " " . $jobRec->user->last);
		return $this->redirect(['action' => 'staff-assign', $jobRec->job_id]);
	}




	/*
	           oooo                                .oooooo..o     .                 .   
	           `888                               d8P'    `Y8   .o8               .o8   
	  .ooooo.   888 .oo.   ooo. .oo.    .oooooooo Y88bo.      .o888oo  .oooo.   .o888oo 
	 d88' `"Y8  888P"Y88b  `888P"Y88b  888' `88b   `"Y8888o.    888   `P  )88b    888   
	 888        888   888   888   888  888   888       `"Y88b   888    .oP"888    888   
	 888   .o8  888   888   888   888  `88bod8P'  oo     .d8P   888 . d8(  888    888 . 
	 `Y8bod8P' o888o o888o o888o o888o `8oooooo.  8""88888P'    "888" `Y888""8o   "888" 
	                                   d"     YD                                        
	                                   "Y88888P'                                        
	*/
	public function changeStatus($id = null, $meth = null)
	{
		$this->RequestHandler->renderAs($this, 'json');
		$this->set('success', false);

		if ( !$this->Auth->user('is_admin') ) {
			$this->set('responseString', "You do not have access to do this!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}

		if ( is_null($id) || is_null($meth) ) {
			$this->set('responseString', "Invalid action!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}

		$job = $this->Jobs->get($id);

		if ( ! $job ) {
			$this->set('responseString', "Record not found!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}
		
		$did = false;
		
		if ( $meth == "open" ) {
			$did = true;
			$this->set('pillID', "open-" . $job->id);
			if ( $job->is_open == 1 ) {
				$job->is_open = 0;
				$this->set('pillText', "Closed");
				$this->set('pillClass', "danger");
				$this->set('responseString', $job->name . " is now closed");
			} else {
				$job->is_open = 1;
				$this->set('pillText', "Open");
				$this->set('pillClass', "success");
				$this->set('responseString', $job->name . " is now open");
			}
		}

		if ( $meth == "active" ) {
			$did = true;
			$this->set('pillID', "act-" . $job->id);
			if ( $job->is_active == 1 ) {
				$job->is_active = 0;
				$this->set('pillText', "In-Active");
				$this->set('pillClass', "danger");
				$this->set('responseString', $job->name . " is now inactive");
			} else {
				$job->is_active = 1;
				$this->set('pillText', "Active");
				$this->set('pillClass', "success");
				$this->set('responseString', $job->name . " is now active");
			}
		}

		if ( $did ) {
			if ( $this->Jobs->save($job) ) {
				$this->set('success', true);
				$this->set('_serialize', ['responseString', 'success', 'pillID', 'pillClass', 'pillText']);
			} else {
				$this->set('responseString', "Save failed!");
				$this->set('_serialize', ['responseString', 'success']);
			}
		} else {
			$this->set('responseString', "Invalid method!");
			$this->set('_serialize', ['responseString', 'success']);
		}
	}
}