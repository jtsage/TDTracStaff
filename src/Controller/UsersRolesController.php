<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersRoles Controller
 *
 * @property \App\Model\Table\UsersRolesTable $UsersRoles
 *
 * @method \App\Model\Entity\UsersRole[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersRolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Roles']
        ];
        $usersRoles = $this->paginate($this->UsersRoles);

        $this->set(compact('usersRoles'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Role id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersRole = $this->UsersRoles->get($id, [
            'contain' => ['Users', 'Roles']
        ]);

        $this->set('usersRole', $usersRole);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersRole = $this->UsersRoles->newEntity();
        if ($this->request->is('post')) {
            $usersRole = $this->UsersRoles->patchEntity($usersRole, $this->request->getData());
            if ($this->UsersRoles->save($usersRole)) {
                $this->Flash->success(__('The users role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users role could not be saved. Please, try again.'));
        }
        $users = $this->UsersRoles->Users->find('list', ['limit' => 200]);
        $roles = $this->UsersRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('usersRole', 'users', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersRole = $this->UsersRoles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersRole = $this->UsersRoles->patchEntity($usersRole, $this->request->getData());
            if ($this->UsersRoles->save($usersRole)) {
                $this->Flash->success(__('The users role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users role could not be saved. Please, try again.'));
        }
        $users = $this->UsersRoles->Users->find('list', ['limit' => 200]);
        $roles = $this->UsersRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('usersRole', 'users', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersRole = $this->UsersRoles->get($id);
        if ($this->UsersRoles->delete($usersRole)) {
            $this->Flash->success(__('The users role has been deleted.'));
        } else {
            $this->Flash->error(__('The users role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
