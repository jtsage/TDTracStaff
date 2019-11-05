<?php
namespace App\Controller;

use App\Controller\AppController;

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
				]
			])
			->where($where)
			->order([
				"date_start" => "DESC",
				"name" => "ASC"
			]);

		$jobs = $this->paginate($jobFind);

		$this->set(compact('jobs'));
	}

	public function myjobs()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, __("All Jobs")]
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
				]
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
		$job = $this->Jobs->get($id, [
			'contain' => ['Roles', 'Users', 'Payrolls']
		]);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/jobs/", __("Jobs")],
			[null, $job->name]
		]);

		$this->set('job', $job);
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
}
