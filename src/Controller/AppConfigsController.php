<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AppConfigs Controller
 *
 * @property \App\Model\Table\AppConfigsTable $AppConfigs
 *
 * @method \App\Model\Entity\AppConfig[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppConfigsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $appConfigs = $this->paginate($this->AppConfigs);

        $this->set(compact('appConfigs'));
    }

    /**
     * View method
     *
     * @param string|null $id App Config id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appConfig = $this->AppConfigs->get($id, [
            'contain' => []
        ]);

        $this->set('appConfig', $appConfig);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appConfig = $this->AppConfigs->newEntity();
        if ($this->request->is('post')) {
            $appConfig = $this->AppConfigs->patchEntity($appConfig, $this->request->getData());
            if ($this->AppConfigs->save($appConfig)) {
                $this->Flash->success(__('The app config has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app config could not be saved. Please, try again.'));
        }
        $this->set(compact('appConfig'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Config id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appConfig = $this->AppConfigs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appConfig = $this->AppConfigs->patchEntity($appConfig, $this->request->getData());
            if ($this->AppConfigs->save($appConfig)) {
                $this->Flash->success(__('The app config has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app config could not be saved. Please, try again.'));
        }
        $this->set(compact('appConfig'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Config id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appConfig = $this->AppConfigs->get($id);
        if ($this->AppConfigs->delete($appConfig)) {
            $this->Flash->success(__('The app config has been deleted.'));
        } else {
            $this->Flash->error(__('The app config could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
