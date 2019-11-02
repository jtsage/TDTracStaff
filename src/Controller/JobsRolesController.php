<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobsRoles Controller
 *
 * @property \App\Model\Table\JobsRolesTable $JobsRoles
 *
 * @method \App\Model\Entity\JobsRole[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JobsRolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Jobs', 'Roles']
        ];
        $jobsRoles = $this->paginate($this->JobsRoles);

        $this->set(compact('jobsRoles'));
    }

    /**
     * View method
     *
     * @param string|null $id Jobs Role id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobsRole = $this->JobsRoles->get($id, [
            'contain' => ['Jobs', 'Roles']
        ]);

        $this->set('jobsRole', $jobsRole);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobsRole = $this->JobsRoles->newEntity();
        if ($this->request->is('post')) {
            $jobsRole = $this->JobsRoles->patchEntity($jobsRole, $this->request->getData());
            if ($this->JobsRoles->save($jobsRole)) {
                $this->Flash->success(__('The jobs role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The jobs role could not be saved. Please, try again.'));
        }
        $jobs = $this->JobsRoles->Jobs->find('list', ['limit' => 200]);
        $roles = $this->JobsRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('jobsRole', 'jobs', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Jobs Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobsRole = $this->JobsRoles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobsRole = $this->JobsRoles->patchEntity($jobsRole, $this->request->getData());
            if ($this->JobsRoles->save($jobsRole)) {
                $this->Flash->success(__('The jobs role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The jobs role could not be saved. Please, try again.'));
        }
        $jobs = $this->JobsRoles->Jobs->find('list', ['limit' => 200]);
        $roles = $this->JobsRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('jobsRole', 'jobs', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Jobs Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobsRole = $this->JobsRoles->get($id);
        if ($this->JobsRoles->delete($jobsRole)) {
            $this->Flash->success(__('The jobs role has been deleted.'));
        } else {
            $this->Flash->error(__('The jobs role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
