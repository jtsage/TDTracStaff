<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
	public $CONFIG_DATA = "";
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler', [
			'enableBeforeRedirect' => false,
		]);
		$this->loadComponent('Flash');
		$this->loadComponent('Auth', [
			'authenticate' => [
				'Form' => [
					'fields' => ['username' => 'username', 'password' => 'password']
					//'finder' => 'auth'
				]
			],
			'loginAction' => [
				'controller' => 'Users',
				'action' => 'login'
			]
		]);

		// Allow the display action so our pages controller
		// continues to work.
		//$this->Auth->allow(['display']);

		$this->set('WhoAmI', $this->Auth->user('is_admin'));
		$this->set('BudgetAmI', $this->Auth->user('is_budget'));

		if ( $this->Auth->user("is_admin")) {
			$this->loadModel("MailQueues");
			$mq = $this->MailQueues->find("all");
			$this->set("MAILQUEUE", $mq->count());
		}

		// Load the config from the database.
		$this->loadModel("AppConfigs");

		$config = $this->AppConfigs->find('list', [
			'keyField' => 'key_name',
			'valueField' => 'value_long'
		]);
		$configArr = $config->toArray();

		$this->set("CONFIG", $configArr);
		$this->CONFIG_DATA = $configArr;
	}
}
