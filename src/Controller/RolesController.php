<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
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
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			$this->redirect(["controller" => "jobs", "action" => "index"]);
		}
		$roles = $this->Roles->find("all")
			->order(['sort_order' => 'ASC']);
			
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, __("View Worker Titles")]
		]);
		$this->set(compact('roles'));
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
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			$this->redirect(["controller" => "jobs", "action" => "index"]);
		}

		$role = $this->Roles->get($id, [
			'contain' => ['Jobs', 'Users', 'UsersJobs']
		]);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, $role->title]
		]);

		$this->set('role', $role);
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
			$this->redirect(["controller" => "jobs", "action" => "index"]);
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, __("Add New Worker Title")]
		]);
		$role = $this->Roles->newEntity();
		if ($this->request->is('post')) {
			$role = $this->Roles->patchEntity($role, $this->request->getData());
			if ($this->Roles->save($role)) {
				$this->Flash->success(__('The employee title has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The employee title could not be saved. Please, try again.'));
		}
		$this->set(compact('role'));
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
			$this->redirect(["controller" => "jobs", "action" => "index"]);
		}
		
		$role = $this->Roles->get($id, [
			'contain' => ['Jobs', 'Users']
		]);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			["/roles/view/" . $role->id, $role->title],
			[null, __("Edit")]
		]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$role = $this->Roles->patchEntity($role, $this->request->getData());
			if ($this->Roles->save($role)) {
				$this->Flash->success(__('The employee title has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The employee title could not be saved. Please, try again.'));
		}
		$this->set(compact('role'));
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
			$this->redirect(["controller" => "jobs", "action" => "index"]);
		}
		
		$role = $this->Roles->get($id);
		if ($this->Roles->delete($role)) {
			$this->Flash->success(__('The employee title has been deleted.'));
		} else {
			$this->Flash->error(__('The employee title could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
