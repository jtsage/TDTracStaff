<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 *
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BudgetsController extends AppController
{
	/*
	  o8o                    .o8                        
	  `"'                   "888                        
	 oooo  ooo. .oo.    .oooo888   .ooooo.  oooo    ooo 
	 `888  `888P"Y88b  d88' `888  d88' `88b  `88b..8P'  
	  888   888   888  888   888  888ooo888    Y888'    
	  888   888   888  888   888  888    .o  .o8"'88b   
	 o888o o888o o888o `Y8bod88P" `Y8bod8P' o88'   888o 
	*/
	public function index() {
		if ( !$this->Auth->user('is_budget') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}

		$this->loadModel("Jobs");

		$openJob = $this->Jobs->find("all")
			->where([
				"is_open"    => 1,
				"has_budget" => 1
			])
			->order([
				'date_start' => 'DESC',
				'name'       => 'asc'
			]);

		$closeJob = $this->Jobs->find("all")
			->where([
				"is_open"    => 0,
				"has_budget" => 1
			])
			->order([
				'date_start' => 'DESC',
				'name'       => 'asc'
			]);

		$budgeTotal = $this->Budgets->find("totalList");
		$this->set("budgeTotal", $budgeTotal->toArray());

		$this->set(compact('openJob','closeJob'));
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
		if ( !$this->Auth->user('is_budget') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}
		if ( is_null($id) ) {
			$this->Flash->error("Error: Job ID not provided");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}

		$job = $this->loadModel("Jobs")->get($id);

		if ( ! $job->has_budget ) {
			$this->Flash->error("This job does not accept budget items");
			return $this->redirect(["controller" => "Jobs", "action" => "view", $job->id]);
		}

		$budgets = $this->Budgets->find("all")
			->contain(["Users" => ["fields" => ["Users.last", "Users.first", "Users.id"]]])
			->where(["job_id" => $job->id])
			->order([
				"category" => "ASC",
				"date"     => "ASC",
				"vendor"   => "ASC",
				"detail"   => "ASC"
			]);

		$budgeTotal = $this->Budgets->find("totalList");
		$this->set("budgeTotal", $budgeTotal->toArray());

		$this->set(compact('budgets', 'job'));
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
	public function add($jobID = null)
	{
		if ( !$this->Auth->user('is_budget') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}
		if ( is_null($jobID) ) {
			$this->Flash->error("Error: Job ID not provided");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}

		$job = $this->loadModel("Jobs")->get($jobID);
		$this->set("job", $job);

		if ( ! $job->has_budget ) {
			$this->Flash->error("This job does not accept budget items");
			return $this->redirect(["controller" => "Jobs", "action" => "view", $job->id]);
		}

		$budget = $this->Budgets->newEntity();
		if ($this->request->is('post')) {
			$budget = $this->Budgets->patchEntity($budget, $this->request->getData());

			$budget->user_id = $this->Auth->User("id");
			$budget->job_id = $job->id;

			if ($this->Budgets->save($budget)) {
				$this->Flash->success(__('The budget has been saved.'));

				return $this->redirect(['action' => 'view', $job->id]);
			}
			$this->Flash->error(__('The budget could not be saved. Please, try again.'));
		}

		$allCats = $this->Budgets->find()
			->distinct(['category'])
			->select(['category'])
			->order(["category" => "ASC"]);
		$allVendor = $this->Budgets->find()
			->distinct(['vendor'])
			->select(['vendor'])
			->order(["vendor" => "ASC"]);

		$this->set(compact('budget', 'allCats', 'allVendor', 'users', 'jobs'));
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
		if ( !$this->Auth->user('is_budget') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["controller" => "Jobs", "action" => "index"]);
		}

		$budget = $this->Budgets->get($id);

		if ( !$this->Auth->user('is_admin') && $budget->userid <> $this->Auth->user("id") ) {
			$this->Flash->error("Sorry, non-administators may only delete their own entries.");
			return $this->redirect(["action" => "view", $budget->job_id]);
		}

		$jobID = $budget->job_id;
		if ($this->Budgets->delete($budget)) {
			$this->Flash->success(__('The budget has been deleted.'));
		} else {
			$this->Flash->error(__('The budget could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'view', $jobID]);
	}
}
