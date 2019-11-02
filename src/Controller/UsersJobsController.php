<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersJobs Controller
 *
 * @property \App\Model\Table\UsersJobsTable $UsersJobs
 *
 * @method \App\Model\Entity\UsersJob[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersJobsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Jobs', 'Roles']
        ];
        $usersJobs = $this->paginate($this->UsersJobs);

        $this->set(compact('usersJobs'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Job id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersJob = $this->UsersJobs->get($id, [
            'contain' => ['Users', 'Jobs', 'Roles']
        ]);

        $this->set('usersJob', $usersJob);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersJob = $this->UsersJobs->newEntity();
        if ($this->request->is('post')) {
            $usersJob = $this->UsersJobs->patchEntity($usersJob, $this->request->getData());
            if ($this->UsersJobs->save($usersJob)) {
                $this->Flash->success(__('The users job has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users job could not be saved. Please, try again.'));
        }
        $users = $this->UsersJobs->Users->find('list', ['limit' => 200]);
        $jobs = $this->UsersJobs->Jobs->find('list', ['limit' => 200]);
        $roles = $this->UsersJobs->Roles->find('list', ['limit' => 200]);
        $this->set(compact('usersJob', 'users', 'jobs', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Job id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersJob = $this->UsersJobs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersJob = $this->UsersJobs->patchEntity($usersJob, $this->request->getData());
            if ($this->UsersJobs->save($usersJob)) {
                $this->Flash->success(__('The users job has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users job could not be saved. Please, try again.'));
        }
        $users = $this->UsersJobs->Users->find('list', ['limit' => 200]);
        $jobs = $this->UsersJobs->Jobs->find('list', ['limit' => 200]);
        $roles = $this->UsersJobs->Roles->find('list', ['limit' => 200]);
        $this->set(compact('usersJob', 'users', 'jobs', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Job id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersJob = $this->UsersJobs->get($id);
        if ($this->UsersJobs->delete($usersJob)) {
            $this->Flash->success(__('The users job has been deleted.'));
        } else {
            $this->Flash->error(__('The users job could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
