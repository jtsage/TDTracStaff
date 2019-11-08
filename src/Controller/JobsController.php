<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\I18n\Date;
use Cake\Chronos\ChronosInterface;
use Cake\Chronos\Chronos;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 *
 * @method \App\Model\Entity\Job[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JobsController extends AppController
{
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
			[null, __("All Jobs")]
		]);

		// If not admin, hide non-open and non-active shows from Job view.
		$where = [];

		if ( !$this->Auth->user('is_admin') ) {
			$where = ["is_open" => 1, "is_active" => 1 ];
		}

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where($where)
			->order([
				"date_start" => "DESC",
				"name" => "ASC"
			]);

		$jobs = $this->paginate($jobFind);

		$this->set(compact('jobs'));
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

		$this->loadModel("UsersRoles");
		$this->loadModel("JobsRoles");

		$jobsAvail = $this->JobsRoles->find("all")
			->select("job_id")
			->where(["role_id IN" => $this->UsersRoles->find("all")->select("role_id")->where(["user_id" => $this->Auth->user("id")])]);

		$where = [
			"is_open"   => 1,
			"is_active" => 1,
			"id IN"     => $jobsAvail
		];

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where($where)
			->order([
				"date_start" => "DESC",
				"name"       => "ASC"
			]);

		$jobs = $this->paginate($jobFind);

		$this->set("subtitle", "Qualified For");
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

		$this->loadModel("UsersRoles");
		$this->loadModel("UsersJobs");

		$jobsAvail = $this->UsersJobs->find("all")
			->select("job_id")
			->where([
				"user_id" => $this->Auth->user("id"),
				"is_scheduled" => 1
			 ]);

		$where = [
			"is_open"   => 1,
			"is_active" => 1,
			"id IN"     => $jobsAvail
		];

		$jobFind = $this->Jobs->find("all")
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where($where)
			->order([
				"date_start" => "DESC",
				"name"       => "ASC"
			]);

		$jobs = $this->paginate($jobFind);

		$this->set("subtitle", "Scheduled For");
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

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, $job1->name]
		]);

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
			$this->redirect(["action" => "index"]);
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

			$ents = $this->JobsRoles->newEntities($inserts);
			$rslt = $this->JobsRoles->saveMany($ents);
			$this->Flash->success("Staff requirments updated");
			$this->redirect(["action" => "view", $id]);
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
			$this->redirect(["action" => "index"]);
		}
		$allCats = $this->Jobs->find()
			->select(['category'])
			->order(["category" => "ASC"]);

		$this->set(compact('allCats'));

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
			$this->redirect(["action" => "index"]);
		}
		$allCats = $this->Jobs->find()
			->select(['category'])
			->order(["category" => "ASC"]);

		$this->set(compact('allCats'));

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("Add New Jobs")]
		]);

		$job = $this->Jobs->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
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
			$this->redirect(["action" => "index"]);
		}
		$this->request->allowMethod(['post', 'delete']);
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
			$this->redirect(["action" => "index"]);
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
			$this->redirect(["action" => "index"]);
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

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			["/jobs/view/" . $job->id, $job->name],
			[null, "Assigned Staff"]
		]);
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
	function schedSet ($intId = null, $value = null )
	{
		if ( is_null($intId) || is_null($value) ) {
			$this->Flash->error(__('Invalid Action'));
			$this->redirect(['action' => 'index']);
		}
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			$this->redirect(["action" => "index"]);
		}

		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->get($intId);

		$jobRec->is_scheduled = $value;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Schedule Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		$this->redirect(['action' => 'staffAssign', $jobRec->job_id]);
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
			$this->redirect(['action' => 'myjobs']);
		}
		if ( is_null($avail) || is_null($roleId) ) {
			$this->Flash->error(__('Invalid Action'));
			$this->redirect(['action' => 'available', $jobId]);
		}
		$this->loadModel("UsersJobs");

		$jobRec = $this->UsersJobs->newEntity();

		$jobRec->user_id = $this->Auth->user("id");
		$jobRec->role_id = $roleId;
		$jobRec->job_id = $jobId;
		$jobRec->is_available = $avail;

		if ($this->UsersJobs->save($jobRec)) {
			$this->Flash->success(__('Availability Updated.'));
		} else {
			$this->Flash->error(__('Something went wrong. Please, try again.'));
		}
		$this->redirect(['action' => 'available', $jobId]);
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
			$this->redirect(['action' => 'myjobs']);
		}
		if ( is_null($avail) || is_null($roleId) ) {
			$this->Flash->error(__('Invalid Action'));
			$this->redirect(['action' => 'available', $jobId]);
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
		$this->redirect(['action' => 'available', $jobId]);
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
							"detail"   => $job->detail,
							"category" => $job->category,
							"location" => $job->location,
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
}
