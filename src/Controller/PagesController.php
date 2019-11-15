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

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

	/**
	 * Displays a view
	 *
	 * @return void|\Cake\Network\Response
	 * @throws \Cake\Network\Exception\NotFoundException When the view file could not
	 *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
	 */
	public function display()
	{
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		$this->set(compact('page', 'subpage'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingTemplateException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function pickdash() {
		if ( ! $this->Auth->user('is_admin') ) {
			$this->dash();
		} else {
			$this->admindash();
		}
	}

	public function dash()
	{
		$this->loadModel('Users');
		$this->loadModel('Payrolls');
		$this->loadModel('Jobs');
		$this->loadModel("JobsRoles");
		$this->loadModel("UsersJobs");
		$this->loadModel('UsersRoles');

		$jobCounts = $this->Jobs->find("jobCounts");
		$this->set('jobCounts', $jobCounts->first());


		$myPayroll = $this->Payrolls->find("payTotals", ["user" => $this->Auth->User("id")]);
		$this->set("myPay", $myPayroll->first());

		$myPossible = $this->JobsRoles->find("all")
			->contain(["Jobs"])
			->select(["job_id"])
			->group(["job_id"])
			->where([
				"role_id IN" => $this->UsersRoles->find("all")->select(["role_id"])->where(["user_id" => $this->Auth->User("id")]),
				"Jobs.is_active" => 1
			]);
		$this->set("myPoss", $myPossible->count());

		$mySched = $this->UsersJobs->find("all")
			->select(["job_id"])
			->where([
				"user_id" => $this->Auth->User("id"),
			])
			->group(["job_id"]);

		$this->set("mySched", $mySched->count());
		

		$this->render('dashboard');
	}

	public function admindash()
	{
		$this->loadModel('Users');
		$this->loadModel('Payrolls');
		$this->loadModel('Jobs');
		$this->loadModel("JobsRoles");
		$this->loadModel("UsersJobs");
		$this->loadModel('UsersRoles');

		$userCnt = $this->Users->findByIsActive(1);
		$this->set("totUser", $userCnt->count());

		$jobCounts = $this->Jobs->find("jobCounts");
		$this->set('jobCounts', $jobCounts->first());


		$openPosCount = $this->JobsRoles->find("all");
		$openPosCount
			->select([
				"jobstot" => $openPosCount->func()->sum("number_needed")
			])
			->where([
				"job_id IN" => $this->Jobs->find("all")->select(["id"])->where(["is_open" => 1])
			]);

		$this->set("availPos", $openPosCount->first()->jobstot);
		


		$myPayroll = $this->Payrolls->find("payTotals");
		$this->set("myPay", $myPayroll->first());

		$jobPayTotal = $this->Payrolls->find("jobTotals")->order(['Jobs.date_start' => 'DESC', 'Jobs.name' => 'asc']);
		$this->set("jobPayTotal", $jobPayTotal->toArray());

		$userPayTotal = $this->Payrolls->find('userTotals')->order(["Users.last" => "ASC", "Users.first" => "ASC"]);
		$this->set("userPayTotal", $userPayTotal);
		

		$this->render('admindashboard');
	}
}
