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
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index()
	{
		$roles = $this->Roles->find("all")
			->order(['sort_order' => 'ASC']);
			
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, __("View Worker Titles")]
		]);
		$this->set(compact('roles'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Role id.
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$role = $this->Roles->get($id, [
			'contain' => ['Jobs', 'Users', 'UsersJobs']
		]);

		$this->set('role', $role);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, __("Add New Worker Title")]
		]);
		$role = $this->Roles->newEntity();
		if ($this->request->is('post')) {
			$role = $this->Roles->patchEntity($role, $this->request->getData());
			if ($this->Roles->save($role)) {
				$this->Flash->success(__('The role has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The role could not be saved. Please, try again.'));
		}
		$jobs = $this->Roles->Jobs->find('list', ['limit' => 200]);
		$users = $this->Roles->Users->find('list', ['limit' => 200]);
		$this->set(compact('role', 'jobs', 'users'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Role id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/roles/", __("Worker Titles")],
			[null, __("Edit Worker Title")]
		]);
		$role = $this->Roles->get($id, [
			'contain' => ['Jobs', 'Users']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$role = $this->Roles->patchEntity($role, $this->request->getData());
			if ($this->Roles->save($role)) {
				$this->Flash->success(__('The role has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The role could not be saved. Please, try again.'));
		}
		$jobs = $this->Roles->Jobs->find('list', ['limit' => 200]);
		$users = $this->Roles->Users->find('list', ['limit' => 200]);
		$this->set(compact('role', 'jobs', 'users'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Role id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$role = $this->Roles->get($id);
		if ($this->Roles->delete($role)) {
			$this->Flash->success(__('The role has been deleted.'));
		} else {
			$this->Flash->error(__('The role could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
