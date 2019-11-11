<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Chronos\Chronos;

/**
 * Payrolls Controller
 *
 * @property \App\Model\Table\PayrollsTable $Payrolls
 *
 * @method \App\Model\Entity\Payroll[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayrollsController extends AppController
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
			$this->redirect(["action" => "mine"]);
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "All Hours - System Wide"]
		]);

		$pays = $this->Payrolls->find("all")
			->contain([
				"Users" => ["fields" => ["first", "last", "id"]],
				"Jobs" => ["fields" => ["id", "name"]]
			])
			->order([
				"Users.last" => "ASC",
				"date_worked" => "DESC",
				"Payrolls.created_at" => "DESC"
			]);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->indexBy('user_id'));

		// $this->set("jobTotals", $this->Payrolls->find('jobTotals')->indexBy('job_id'));
			
		$payrolls = $this->paginate($pays);

		$this->set("userCounts", true);
		$this->set("multiUser", true);
		$this->set(compact('payrolls'));
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
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "Add Hours"]
		]);

		$payroll = $this->Payrolls->newEntity();
		if ($this->request->is('post')) {

			$fixed_data = array_merge($this->request->getData(), ['is_paid' => 0, 'user_id' => $this->Auth->user("id")]);

			if ( $this->CONFIG_DATA['require-hours'] ) {
				$fixed_data['time_start'] = Chronos::createFromFormat('H:i',$this->request->getData('time_start'));
				$fixed_data['time_end'] = Chronos::createFromFormat('H:i',$this->request->getData('time_end'));
				$fixed_data['hours_worked'] = ($fixed_data['time_end']->diffInMinutes($fixed_data['time_start']) / 60);
			} else {
				$fixed_data['time_start'] = Chronos::createFromFormat('H:i',"0:00");
				$fixed_data['time_end'] = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end'] = $fixed_data["time_end"]->addMinutes(intval($fixed_data["hours_worked"] * 60));
			}

			$payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
			if ($this->Payrolls->save($payroll)) {
				$this->Flash->success(__('The payroll has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The payroll could not be saved. Please, try again.'));
		}

		$users = $this->Payrolls->Users->find('list',  [
				'keyField'   => 'id',
				'valueField' => function ($row) {
					return $row['last'] . ', ' . $row['first'];
				},
				'limit'      => 500
			])
			->where([
				"id" => $this->Auth->user("id")
			])
			->order([
				"last"  => "ASC",
				"first" => "ASC"
			]);
			
		$this->loadModel("UsersJobs");

		if ( !is_null($jobID) ) {
			$sched_jobs_list = $this->UsersJobs->find("all")
				->distinct(["job_id"])
				->select(["job_id"])
				->where([
					"user_id" => $this->Auth->user("id"),
					"is_scheduled" => 1,
					"job_id" => $jobID
				]);
			
			if ( $sched_jobs_list->count() < 1 && !$this->CONFIG_DATA["allow-unscheduled-hours"] ) {
				$this->Flash->error(__('You are not scheduled for that show, sorry'));
				return $this->redirect(['controller' => 'jobs', 'action' => 'view', $jobID]);
			}

			$jobs_sch = $this->Payrolls->Jobs->find('list', [
				'keyField' => 'id',
				'valueField' => function ($row) {
					return $row["name"] . " (scheduled)";
				}
			])
			->where([
				"id" => $jobID,
				"is_open" => 1,
				"is_active" => 1
			])
			->order(["date_start" => "DESC", "name" => "ASC"]);

			$jobs = $jobs_sch->toArray();
		} else {
			$sched_jobs_list = $this->UsersJobs->find("all")
				->distinct(["job_id"])
				->select(["job_id"])
				->where([
					"user_id" => $this->Auth->user("id"),
					"is_scheduled" => 1
				]);

			$jobs_sch = $this->Payrolls->Jobs->find('list', [
				'keyField' => 'id',
				'valueField' => function ($row) {
					return $row["name"] . " (scheduled)";
				}
			])
			->where([
				"id IN" => $sched_jobs_list,
				"is_open" => 1,
				"is_active" => 1
			])
			->order(["date_start" => "DESC", "name" => "ASC"]);

			$jobs = $jobs_sch->toArray();

			if ( $this->CONFIG_DATA["allow-unscheduled-hours"] ) {
				$jobs_otr = $this->Payrolls->Jobs->find('list', [
					'keyField' => 'id',
					'valueField' => function ($row) {
						return $row["name"] . " (not scheduled)";
					}
				])
				->where([
					"id NOT IN" => $sched_jobs_list,
					"is_open" => 1,
					"is_active" => 1
				])
				->order(["date_start" => "DESC", "name" => "ASC"]);
				$jobs = array_merge($jobs, $jobs_otr->toArray());
			}
		}
		
		if ( count($jobs) < 1 ) {
			$this->Flash->error(__('Unable to find any jobs'));
			return $this->redirect(['controller' => 'jobs', 'action' => 'index']);
		}

		$this->set(compact('payroll', 'users', 'jobs'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Payroll id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			$this->redirect(["action" => "index"]);
		}
		$payroll = $this->Payrolls->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$payroll = $this->Payrolls->patchEntity($payroll, $this->request->getData());
			if ($this->Payrolls->save($payroll)) {
				$this->Flash->success(__('The payroll has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The payroll could not be saved. Please, try again.'));
		}
		$users = $this->Payrolls->Users->find('list', ['limit' => 200]);
		$jobs = $this->Payrolls->Jobs->find('list', ['limit' => 200]);
		$this->set(compact('payroll', 'users', 'jobs'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Payroll id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$payroll = $this->Payrolls->get($id);
		if ($this->Payrolls->delete($payroll)) {
			$this->Flash->success(__('The payroll has been deleted.'));
		} else {
			$this->Flash->error(__('The payroll could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
