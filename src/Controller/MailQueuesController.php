<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MailQueues Controller
 *
 * @property \App\Model\Table\MailQueuesTable $MailQueues
 *
 * @method \App\Model\Entity\MailQueue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MailQueuesController extends AppController
{
	public $paginate = [
		'limit' => 100,
		'order' => [
			'created_at'    => 'DESC',
		]
	];
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index()
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect("/");
		}

		$mailQueues = $this->paginate($this->MailQueues);

		$this->set(compact('mailQueues'));

		$this->set('crumby', [
			["/", __("Dashboard")],
			[null, __("E-Mail Outbox")]
		]);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Mail Queue id.
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect("/");
		}

		$mailQueue = $this->MailQueues->get($id, [
			'contain' => []
		]);

		$this->set('mailQueue', $mailQueue);
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/mail-queues/", "E-Mail Outbox"],
			[null, __("View E-Mail")]
		]);
	}


	/**
	 * Delete method
	 *
	 * @param string|null $id Mail Queue id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect("/");
		}
		
		$mailQueue = $this->MailQueues->get($id);
		if ($this->MailQueues->delete($mailQueue)) {
			$this->Flash->success(__('The mail queue has been deleted.'));
		} else {
			$this->Flash->error(__('The mail queue could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
