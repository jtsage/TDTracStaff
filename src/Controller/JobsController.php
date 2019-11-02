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
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null
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
			->where($where)
			->order([
				"date_start" => "DESC",
				"name" => "ASC"
			]);

		$jobs = $this->paginate($jobFind);

		$this->set(compact('jobs'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$job = $this->Jobs->get($id, [
			'contain' => ['Roles', 'Users', 'Payrolls']
		]);

		$this->set('job', $job);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
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
		$roles = $this->Jobs->Roles->find('list', ['limit' => 200]);
		$users = $this->Jobs->Users->find('list', ['limit' => 200]);
		$this->set(compact('job', 'roles', 'users'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$job = $this->Jobs->get($id, [
			'contain' => ['Roles', 'Users']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$job = $this->Jobs->patchEntity($job, $this->request->getData());
			if ($this->Jobs->save($job)) {
				$this->Flash->success(__('The job has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The job could not be saved. Please, try again.'));
		}
		$roles = $this->Jobs->Roles->find('list', ['limit' => 200]);
		$users = $this->Jobs->Users->find('list', ['limit' => 200]);
		$this->set(compact('job', 'roles', 'users'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
}
