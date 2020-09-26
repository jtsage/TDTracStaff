<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reminders Controller
 *
 * @property \App\Model\Table\RemindersTable $Reminders
 *
 * @method \App\Model\Entity\Reminder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RemindersController extends AppController
{
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$reminders = $this->paginate($this->Reminders);
		$this->set('crumby', [
			["/", __("Dashboard")],
			[null, __("Reminders")]
		]);

		$this->set(compact('reminders'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Reminder id.
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$this->loadModel("Users");

		$users = $this->Users->find("all")
			->where(["is_active" => 1])
			->order(["last" => "ASC", "first" => "ASC"]);
		$users = $this->Users->find('list', [
				'keyField' => 'id',
				'valueField' => 'commaName'
			]);

		$reminder = $this->Reminders->get($id, [
			'contain' => [],
		]);

		$this->set('reminder', $reminder);
		$this->set('users', $users->toArray());

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/reminders/", __("Reminders")],
			[null, $reminder->description]
		]);
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

		$this->loadModel("Users");

		$users = $this->Users->find("all")
			->where(["is_active" => 1])
			->order(["last" => "ASC", "first" => "ASC"]);
		
		$reminder = $this->Reminders->newEntity();
		if ($this->request->is('post')) {
			$reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());
			$users = $this->request->getData();
			$usersToSend = [];

			foreach ( $users as $name => $value ) {
				if ( preg_match("/^user_.+?/", $name ) && $value == 1 ) {
					$usersToSend[] = substr($name,5);
				}
			}
			$reminder->toUsers = json_encode($usersToSend);

			if ($this->Reminders->save($reminder)) {
				$this->Flash->success(__('The reminder has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The reminder could not be saved. Please, try again.'));
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/reminders/", __("Reminders")],
			[null, __("Add Reminder")]
		]);
		
		$this->set(compact('reminder', 'users'));
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

		$this->loadModel("Users");

		$users = $this->Users->find("all")
			->where(["is_active" => 1])
			->order(["last" => "ASC", "first" => "ASC"]);

		$reminder = $this->Reminders->get($id, [
			'contain' => [],
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$reminder = $this->Reminders->patchEntity($reminder, $this->request->getData());

			$users = $this->request->getData();
			$usersToSend = [];

			foreach ( $users as $name => $value ) {
				if ( preg_match("/^user_.+?/", $name ) && $value == 1 ) {
					$usersToSend[] = substr($name,5);
				}
			}
			$reminder->toUsers = json_encode($usersToSend);

			if ($this->Reminders->save($reminder)) {
				$this->Flash->success(__('The reminder has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The reminder could not be saved. Please, try again.'));
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/reminders/", __("Reminders")],
			[null, __("Edit Reminder")]
		]);

		$this->set(compact('reminder', 'users'));
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

		$this->request->allowMethod(['post', 'delete']);
		$reminder = $this->Reminders->get($id);
		if ($this->Reminders->delete($reminder)) {
			$this->Flash->success(__('The reminder has been deleted.'));
		} else {
			$this->Flash->error(__('The reminder could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
