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

		if ( ! $this->Auth->user('is_admin')) {
			$this->Flash->error(__('You may not configure this application'));
			return $this->redirect(["controller" => "jobs", "action" => "index"]);
		}

		$configs = $this->AppConfigs->find("all")
			->order([
				"key_name" => "ASC"
			]);

		$appConfigs = $configs;

		$this->set('crumby', [
			["/", __("Dashboard")],
			[null, __("Application Configuration")]
		]);
		$this->set(compact('appConfigs'));
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
		if ( ! $this->Auth->user('is_admin')) {
			$this->Flash->error(__('You may not configure this application'));
			return $this->redirect(["controller" => "jobs", "action" => "index"]);
		}
		$appConfig = $this->AppConfigs->get($id, [
			'contain' => []
		]);
			
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/app-configs", __("Application Configuration")],
			[null, $appConfig->key_name]
		]);
		$this->set('appConfig', $appConfig);
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
		if ( ! $this->Auth->user('is_admin')) {
			$this->Flash->error(__('You may not configure this application'));
			return $this->redirect(["controller" => "jobs", "action" => "index"]);
		}
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
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/app-configs", __("Application Configuration")],
			[null, "Add New - Be Careful!!"]
		]);
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
		if ( ! $this->Auth->user('is_admin')) {
			$this->Flash->error(__('You may not configure this application'));
			return $this->redirect(["controller" => "jobs", "action" => "index"]);
		}
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
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/app-configs", __("Application Configuration")],
			["/app-configs/view/" . $appConfig->id, $appConfig->key_name],
			[null, "Edit Value"]
		]);
	}
}
