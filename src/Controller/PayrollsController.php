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
	/*
	  o8o                    .o8                        
	  `"'                   "888                        
	 oooo  ooo. .oo.    .oooo888   .ooooo.  oooo    ooo 
	 `888  `888P"Y88b  d88' `888  d88' `88b  `88b..8P'  
	  888   888   888  888   888  888ooo888    Y888'    
	  888   888   888  888   888  888    .o  .o8"'88b   
	 o888o o888o o888o `Y8bod88P" `Y8bod8P' o88'   888o 
	*/
	public function index()
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mine"]);
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "All Hours - System Wide"]
		]);

		$pays = $this->Payrolls->find("listDetail");

		$this->set("userTotals", $this->Payrolls->find('userTotals')->indexBy('user_id')->toArray());
			
		$payrolls = $this->paginate($pays);
		$this->set("isPaged", true);

		$this->set("mainTitle", "System Wide Payroll Hours");
		$this->set("subTitle", "This shows the system-wide payroll hours, both paid and unpaid. This view is only available to administrators.");
		$this->set("userCounts", true);
		$this->set("userCountsUnpaidOnly", false);
		$this->set("multiUser", true);
		$this->set(compact('payrolls'));
	}



	/*
	                                               o8o        .o8  
	                                               `"'       "888  
	 oooo  oooo  ooo. .oo.   oo.ooooo.   .oooo.   oooo   .oooo888  
	 `888  `888  `888P"Y88b   888' `88b `P  )88b  `888  d88' `888  
	  888   888   888   888   888   888  .oP"888   888  888   888  
	  888   888   888   888   888   888 d8(  888   888  888   888  
	  `V88V"V8P' o888o o888o  888bod8P' `Y888""8o o888o `Y8bod88P" 
	                          888                                  
	                         o888o                                 
	*/
	public function unpaid()
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mine", "unpaid"]);
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "All Unpaid Hours - System Wide"]
		]);

		$pays = $this->Payrolls->find("listDetail")->where(["is_paid"=>0]);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->where(["is_paid"=>0])->indexBy('user_id')->toArray());
			
		$payrolls = $pays;
		$this->set("isPaged", false);

		$this->set("mainTitle", "System Wide Unpaid Payroll Hours");
		$this->set("subTitle", "This shows the system-wide payroll hours, unpaid only. This view is only available to administrators.");
		$this->set("userCounts", true);
		$this->set("userCountsUnpaidOnly", true);
		$this->set("multiUser", true);
		$this->set(compact('payrolls'));
		$this->render("index");
	}



	/*
	                    o8o                        
	                    `"'                        
	 ooo. .oo.  .oo.   oooo  ooo. .oo.    .ooooo.  
	 `888P"Y88bP"Y88b  `888  `888P"Y88b  d88' `88b 
	  888   888   888   888   888   888  888ooo888 
	  888   888   888   888   888   888  888    .o 
	 o888o o888o o888o o888o o888o o888o `Y8bod8P' 
	*/
	public function mine($unpaid = null)
	{

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "My Hours" . ( !is_null($unpaid) ? " - Unpaid" : "")]
		]);

		$where = [ "user_id" => $this->Auth->User("id") ];

		if ( !is_null($unpaid) ) {
			$where[] = [ "is_paid" => 0 ];
		}

		$pays = $this->Payrolls->find("listDetail")->where($where);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->indexBy('user_id')->toArray());
			
		if ( is_null($unpaid) ) {
			$this->set("mainTitle", "Your Payroll Hours");
			$this->set("subTitle", "This shows your payroll hours, both paid and unpaid.");
			$payrolls = $this->paginate($pays);
			$this->set("isPaged", true);
			$this->set("userCountsUnpaidOnly", false);
		} else {
			$this->set("mainTitle", "Your Unpaid Payroll Hours");
			$this->set("subTitle", "This shows your payroll hours, unpaid only.");
			$payrolls = $pays;
			$this->set("isPaged", false);
			$this->set("userCountsUnpaidOnly", true);
		}

		$this->set("userCounts", true);
		$this->set("multiUser", false);
		$this->set(compact('payrolls'));
		$this->render("index");
	}



	/*
	 oooo  oooo   .oooo.o  .ooooo.  oooo d8b 
	 `888  `888  d88(  "8 d88' `88b `888""8P 
	  888   888  `"Y88b.  888ooo888  888     
	  888   888  o.  )88b 888    .o  888     
	  `V88V"V8P' 8""888P' `Y8bod8P' d888b    
	*/
	public function user($userID, $unpaid = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mine"]);
		}

		$user = $this->loadModel("Users")->get($userID);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, $user->full_name . "'s Hours" . ( !is_null($unpaid) ? " - Unpaid" : "")]
		]);

		$where = [ "user_id" => $user->id ];

		if ( !is_null($unpaid) ) {
			$where[] = [ "is_paid" => 0 ];
		}

		$pays = $this->Payrolls->find("listDetail")->where($where);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->indexBy('user_id')->toArray());
			
		if ( is_null($unpaid) ) {
			$this->set("mainTitle", $user->full_name . "'s Payroll Hours");
			$this->set("subTitle", "This shows " .$user->full_name . "'s payroll hours, both paid and unpaid.");
			$payrolls = $this->paginate($pays);
			$this->set("isPaged", true);
			$this->set("userCountsUnpaidOnly", false);
		} else {
			$this->set("mainTitle", $user->full_name . "'s Unpaid Payroll Hours");
			$this->set("subTitle", "This shows " .$user->full_name . "'s payroll hours, unpaid only.");
			$payrolls = $pays;
			$this->set("isPaged", false);
			$this->set("userCountsUnpaidOnly", true);
		}

		$this->set("userCounts", true);
		$this->set("multiUser", false);
		$this->set(compact('payrolls'));
		$this->render("index");
	}



	/*
	     o8o            .o8       
	     `"'           "888       
	    oooo  .ooooo.   888oooo.  
	    `888 d88' `88b  d88' `88b 
	     888 888   888  888   888 
	     888 888   888  888   888 
	     888 `Y8bod8P'  `Y8bod8P' 
	     888                      
	 .o. 88P                      
	 `Y888P                       
	*/
	public function job($jobID, $unpaid = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "myjob", $jobID, $unpaid]);
		}

		$job = $this->loadModel("Jobs")->get($jobID);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, $job->name . "'s Hours" . ( !is_null($unpaid) ? " - Unpaid" : "")]
		]);

		$where = [ "job_id" => $job->id ];

		if ( !is_null($unpaid) ) {
			$where[] = [ "is_paid" => 0 ];
		}

		$pays = $this->Payrolls->find("listDetail")->where($where);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->where(['job_id'=>$jobID])->indexBy('user_id')->toArray());
			
		if ( is_null($unpaid) ) {
			$this->set("mainTitle", $job->name . "'s Payroll Hours");
			$this->set("subTitle", "This shows " .$job->name . "'s payroll hours, both paid and unpaid.");
			$payrolls = $this->paginate($pays);
			$this->set("isPaged", true);
			$this->set("userCountsUnpaidOnly", false);
		} else {
			$this->set("mainTitle", $job->name . "'s Unpaid Payroll Hours");
			$this->set("subTitle", "This shows " .$job->name . "'s payroll hours, unpaid only.");
			$payrolls = $pays;
			$this->set("isPaged", false);
			$this->set("userCountsUnpaidOnly", true);
		}

		$this->set("userCounts", true);
		$this->set("multiUser", true);
		$this->set(compact('payrolls'));
		$this->render("index");
	}



	/*
	                                  oooo            .o8       
	                                  `888           "888       
	 ooo. .oo.  .oo.   oooo    ooo     888  .ooooo.   888oooo.  
	 `888P"Y88bP"Y88b   `88.  .8'      888 d88' `88b  d88' `88b 
	  888   888   888    `88..8'       888 888   888  888   888 
	  888   888   888     `888'        888 888   888  888   888 
	 o888o o888o o888o     .8'     .o. 88P `Y8bod8P'  `Y8bod8P' 
	                   .o..P'      `Y888P                       
	                   `Y8P'                                    
	*/
	public function myjob($jobID, $unpaid = null)
	{
		$job = $this->loadModel("Jobs")->get($jobID);

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "Your " . $job->name . "'s Hours" . ( !is_null($unpaid) ? " - Unpaid" : "")]
		]);

		$where = [ 
			"user_id" => $this->Auth->User("id"),
			"job_id" => $job->id
		];

		if ( !is_null($unpaid) ) {
			$where[] = [ "is_paid" => 0 ];
		}

		$pays = $this->Payrolls->find("listDetail")->where($where);

		$this->set("userTotals", $this->Payrolls->find('userTotals')->where(['job_id'=>$jobID])->indexBy('user_id')->toArray());
			
		if ( is_null($unpaid) ) {
			$this->set("mainTitle", "Your Payroll Hours for " . $job->name);
			$this->set("subTitle", "This shows your payroll hours for " .$job->name . ", both paid and unpaid.");
			$payrolls = $this->paginate($pays);
			$this->set("isPaged", true);
			$this->set("userCountsUnpaidOnly", false);
		} else {
			$this->set("mainTitle", "Your unpaid Payroll Hours for " . $job->name);
			$this->set("subTitle", "This shows your payroll hours for " .$job->name . ", unpaid only.");
			$payrolls = $pays;
			$this->set("isPaged", false);
			$this->set("userCountsUnpaidOnly", true);
		}

		$this->set("userCounts", true);
		$this->set("multiUser", true);
		$this->set(compact('payrolls'));
		$this->render("index");
	}



	/*
	                                        .o8                .             
	                                       "888              .o8             
	 oo.ooooo.   .oooo.   oooo    ooo  .oooo888   .oooo.   .o888oo  .ooooo.  
	  888' `88b `P  )88b   `88.  .8'  d88' `888  `P  )88b    888   d88' `88b 
	  888   888  .oP"888    `88..8'   888   888   .oP"888    888   888ooo888 
	  888   888 d8(  888     `888'    888   888  d8(  888    888 . 888    .o 
	  888bod8P' `Y888""8o     .8'     `Y8bod88P" `Y888""8o   "888" `Y8bod8P' 
	  888                 .o..P'                                             
	 o888o                `Y8P'                                              
	*/
	public function paydate($date = null, $unpaid = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mypaydate", $date, $unpaid]);
		}

		if ( is_null($date) ) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				[null, "List by Payroll Date"]
			]);

			if ($this->request->is('post')) {
				$action = [
					"action" => "paydate",
					$this->request->getData('due_payroll_paid')
				];
				if ( $this->request->getData('unpaid') ) { $action[] = "unpaid"; }
				return $this->redirect($action);
			}
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				["/payrolls/paydate/", "List by Payroll Date"],
				[null, $date]
			]);
	
			$jobs = $this->loadModel("Jobs")->findByDuePayrollPaid($date)->select(["id"]);

			$this->set('jobs', $jobs);
	
			$where = [ "job_id IN" => $jobs ];
	
			if ( !is_null($unpaid) ) {
				$where[] = [ "is_paid" => 0 ];
			}
	
			$pays = $this->Payrolls->find("listDetail")->where($where);
	
			$this->set("userTotals", $this->Payrolls->find('userTotals')->where(['job_id IN'=>$jobs])->indexBy('user_id')->toArray());
				
			if ( is_null($unpaid) ) {
				$this->set("mainTitle", $date . " Pay Date Payroll Hours");
				$this->set("subTitle", "This shows payroll hours, both paid and unpaid for the ". $date . " pay date");
				$payrolls = $this->paginate($pays);
				$this->set("isPaged", true);
				$this->set("userCountsUnpaidOnly", false);
			} else {
				$this->set("mainTitle", $date . " Pay Date Unpaid Payroll Hours");
				$this->set("subTitle", "This shows unpaid payroll hours for the ". $date . " pay date");
				$payrolls = $pays;
				$this->set("isPaged", false);
				$this->set("userCountsUnpaidOnly", true);
			}
	
			$this->set("userCounts", true);
			$this->set("multiUser", true);
			$this->set(compact('payrolls'));
			$this->render("index");
		}
	}



	/*
	       .o8                .                      
	      "888              .o8                      
	  .oooo888   .oooo.   .o888oo  .ooooo.   .oooo.o 
	 d88' `888  `P  )88b    888   d88' `88b d88(  "8 
	 888   888   .oP"888    888   888ooo888 `"Y88b.  
	 888   888  d8(  888    888 . 888    .o o.  )88b 
	 `Y8bod88P" `Y888""8o   "888" `Y8bod8P' 8""888P' 
	*/
	public function dates($start = null, $end = null, $unpaid = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mydates", $start, $end, $unpaid]);
		}

		if ( is_null($start) || is_null($end) ) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				[null, "List by Date Range"]
			]);

			if ($this->request->is('post')) {
				$action = [
					"action" => "dates",
					$this->request->getData('date_start'),
					$this->request->getData('date_end'),

				];
				if ( $this->request->getData('unpaid') ) { $action[] = "unpaid"; }
				return $this->redirect($action);
			}
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				["/payrolls/dates/", "List by Date Range"],
				[null, $start . " through " . $end]
			]);
	
			$where = [ 
				"date_worked >=" => $start,
				"date_worked <=" => $end
			 ];
	
			if ( !is_null($unpaid) ) {
				$where[] = [ "is_paid" => 0 ];
			}
	
			$pays = $this->Payrolls->find("listDetail")->where($where);
	
			$this->set("userTotals", $this->Payrolls->find('userTotals')->where(["date_worked >=" => $start, "date_worked <=" => $end])->indexBy('user_id')->toArray());
				
			if ( is_null($unpaid) ) {
				$this->set("mainTitle", "Date Range: " . $start . " through " . $end . " Payroll Hours");
				$this->set("subTitle", "This shows payroll hours, both paid and unpaid for the date range ". $start . " through " . $end . ".");
				$payrolls = $this->paginate($pays);
				$this->set("isPaged", true);
				$this->set("userCountsUnpaidOnly", false);
			} else {
				$this->set("mainTitle", "Date Range: " . $start . " through " . $end . " Unpaid Payroll Hours");
				$this->set("subTitle", "This shows unpaid payroll hours for the date range ". $start . " through " . $end . ".");
				$payrolls = $pays;
				$this->set("isPaged", false);
				$this->set("userCountsUnpaidOnly", true);
			}
	
			$this->set("userCounts", true);
			$this->set("multiUser", true);
			$this->set(compact('payrolls'));
			$this->render("index");
		}
	}



/*
                                     .o8                .                      
                                    "888              .o8                      
 ooo. .oo.  .oo.   oooo    ooo  .oooo888   .oooo.   .o888oo  .ooooo.   .oooo.o 
 `888P"Y88bP"Y88b   `88.  .8'  d88' `888  `P  )88b    888   d88' `88b d88(  "8 
  888   888   888    `88..8'   888   888   .oP"888    888   888ooo888 `"Y88b.  
  888   888   888     `888'    888   888  d8(  888    888 . 888    .o o.  )88b 
 o888o o888o o888o     .8'     `Y8bod88P" `Y888""8o   "888" `Y8bod8P' 8""888P' 
                   .o..P'                                                      
                   `Y8P'                                                       
*/
	public function mydates($start = null, $end = null, $unpaid = null)
	{
		if ( is_null($start) || is_null($end) ) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				[null, "List by Date Range"]
			]);

			if ($this->request->is('post')) {
				$action = [
					"action" => "mydates",
					$this->request->getData('date_start'),
					$this->request->getData('date_end'),

				];
				if ( $this->request->getData('unpaid') ) { $action[] = "unpaid"; }
				return $this->redirect($action);
			}
			$this->render("dates");
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				["/payrolls/dates/", "List by Date Range"],
				[null, $start . " through " . $end]
			]);
	
			$where = [ 
				"date_worked >=" => $start,
				"date_worked <=" => $end,
				"user_id" => $this->Auth->user("id")
			 ];
	
			if ( !is_null($unpaid) ) {
				$where[] = [ "is_paid" => 0 ];
			}
	
			$pays = $this->Payrolls->find("listDetail")->where($where);
	
			$this->set("userTotals", $this->Payrolls->find('userTotals')->where(["date_worked >=" => $start, "date_worked <=" => $end])->indexBy('user_id')->toArray());
				
			if ( is_null($unpaid) ) {
				$this->set("mainTitle", "Your Date Range: " . $start . " through " . $end . " Payroll Hours");
				$this->set("subTitle", "This shows your payroll hours, both paid and unpaid for the date range ". $start . " through " . $end . ".");
				$payrolls = $this->paginate($pays);
				$this->set("isPaged", true);
				$this->set("userCountsUnpaidOnly", false);
			} else {
				$this->set("mainTitle", "Your Date Range: " . $start . " through " . $end . " Unpaid Payroll Hours");
				$this->set("subTitle", "This shows your unpaid payroll hours for the date range ". $start . " through " . $end . ".");
				$payrolls = $pays;
				$this->set("isPaged", false);
				$this->set("userCountsUnpaidOnly", true);
			}
	
			$this->set("userCounts", true);
			$this->set("multiUser", false);
			$this->set(compact('payrolls'));
			$this->render("index");
		}
	}



	/*
	                                                                      .o8                .             
	                                                                     "888              .o8             
	 ooo. .oo.  .oo.   oooo    ooo oo.ooooo.   .oooo.   oooo    ooo  .oooo888   .oooo.   .o888oo  .ooooo.  
	 `888P"Y88bP"Y88b   `88.  .8'   888' `88b `P  )88b   `88.  .8'  d88' `888  `P  )88b    888   d88' `88b 
	  888   888   888    `88..8'    888   888  .oP"888    `88..8'   888   888   .oP"888    888   888ooo888 
	  888   888   888     `888'     888   888 d8(  888     `888'    888   888  d8(  888    888 . 888    .o 
	 o888o o888o o888o     .8'      888bod8P' `Y888""8o     .8'     `Y8bod88P" `Y888""8o   "888" `Y8bod8P' 
	                   .o..P'       888                 .o..P'                                             
	                   `Y8P'       o888o                `Y8P'                                              
	*/
	public function mypaydate($date = null, $unpaid = null)
	{
		if ( is_null($date) ) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				[null, "List by Payroll Date"]
			]);

			if ($this->request->is('post')) {
				$action = [
					"action" => "mypaydate",
					$this->request->getData('due_payroll_paid')
				];
				if ( $this->request->getData('unpaid') ) { $action[] = "unpaid"; }
				return $this->redirect($action);
			}
			$this->render("paydate");
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/payrolls/", __("Hours")],
				["/payrolls/mypaydate/", "List by Payroll Date"],
				[null, $date]
			]);
	
			$jobs = $this->loadModel("Jobs")->findByDuePayrollPaid($date)->select(["id"]);

			$this->set('jobs', $jobs);
	
			$where = [ "job_id IN" => $jobs, "user_id" => $this->Auth->user("id") ];
	
			if ( !is_null($unpaid) ) {
				$where[] = [ "is_paid" => 0 ];
			}
	
			$pays = $this->Payrolls->find("listDetail")->where($where);
	
			$this->set("userTotals", $this->Payrolls->find('userTotals')->where(['job_id IN'=>$jobs])->indexBy('user_id')->toArray());
				
			if ( is_null($unpaid) ) {
				$this->set("mainTitle", "Your " . $date . " Pay Date Payroll Hours");
				$this->set("subTitle", "This shows your payroll hours, both paid and unpaid for the ". $date . " pay date");
				$payrolls = $this->paginate($pays);
				$this->set("isPaged", true);
				$this->set("userCountsUnpaidOnly", false);
			} else {
				$this->set("mainTitle", "Your " . $date . " Pay Date Unpaid Payroll Hours");
				$this->set("subTitle", "This shows your unpaid payroll hours for the ". $date . " pay date");
				$payrolls = $pays;
				$this->set("isPaged", false);
				$this->set("userCountsUnpaidOnly", true);
			}
	
			$this->set("userCounts", true);
			$this->set("multiUser", false);
			$this->set(compact('payrolls'));
			$this->render("index");
		}
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

			$fixed_data = array_merge($this->request->getData(), [
				'is_paid' => 0,
				'user_id' => $this->Auth->user("id")
			]);
			$job = $this->loadModel("Jobs")->get($fixed_data['job_id']);

			if ( !$job->has_payroll ) {
				$this->Flash->error(__('Sorry, this job does not allow payroll to be tracked.'));
				return $this->redirect(['controller' => 'jobs', 'action' => 'view', $job->id]);
			}

			if ( $this->CONFIG_DATA['require-hours'] ) {
				$fixed_data['time_start']   = Chronos::createFromFormat('H:i', $this->request->getData('time_start'));
				$fixed_data['time_end']     = Chronos::createFromFormat('H:i', $this->request->getData('time_end'));
				$fixed_data['hours_worked'] = ($fixed_data['time_end']->diffInMinutes($fixed_data['time_start']) / 60);
			} else {
				$fixed_data['time_start'] = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = $fixed_data["time_end"]->addMinutes(intval($fixed_data["hours_worked"] * 60));
			}

			$payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
			if ($this->Payrolls->save($payroll)) {
				$this->Flash->success(__('The payroll has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The payroll could not be saved. Please, try again.'));
		}

		$users = [ $this->Auth->User("id") => $this->Auth->User("first") . " " . $this->Auth->User("last") ];
			
		$this->loadModel("UsersJobs");

		$sched_jobs_list = $this->UsersJobs->find("mine", [
			"userID"      =>  $this->Auth->user("id"),
			"true_filter" => "is_scheduled"
		]);

		if ( !is_null($jobID) ) {
			$job = $this->loadModel("Jobs")->get($jobID);

			if ( !$job->has_payroll ) {
				$this->Flash->error(__('Sorry, this job does not allow payroll to be tracked.'));
				return $this->redirect(['controller' => 'jobs', 'action' => 'view', $job->id]);
			}
			if ( !$this->CONFIG_DATA["allow-unscheduled-hours"] ) {
				if ( !in_array($job->id, array_keys($sched_jobs_list->indexBy('job_id')->toArray()) ) ) {
					$this->Flash->error(__('You are not scheduled for this job!'));
					return $this->redirect(['controller' => 'jobs', 'action' => 'view', $job->id]);
				}
			}
			$jobs = [ $job->id => $job->name ];
		} else {

			$jobs_sch = $this->Payrolls->Jobs->find("activeOpenListAlpha", [
				'keyField'   => 'id',
				'valueField' => function ($row) {
					return $row["name"] . " (scheduled)";
				}
			])->where([
				"id IN" => $sched_jobs_list
			]);

			$jobs = $jobs_sch->toArray();

			if ( $this->CONFIG_DATA["allow-unscheduled-hours"] ) {
				$jobs_otr = $this->Payrolls->Jobs->find("activeOpenList", [
					'keyField'   => 'id',
					'valueField' => function ($row) {
						return $row["name"] . " (not scheduled)";
					}
				])->where([
					"id NOT IN" => $sched_jobs_list
				]);

				$jobs = array_merge($jobs, $jobs_otr->toArray());
			}
		}
		
		if ( count($jobs) < 1 ) {
			$this->Flash->error(__('Unable to find any jobs'));
			return $this->redirect(['controller' => 'jobs', 'action' => 'index']);
		}

		$this->set(compact('payroll', 'users', 'jobs'));
	}



	/*
	                 .o8        .o8  oooooooooooo                                        
	                "888       "888  `888'     `8                                        
	  .oooo.    .oooo888   .oooo888   888          .ooooo.  oooo d8b  .ooooo.   .ooooo.  
	 `P  )88b  d88' `888  d88' `888   888oooo8    d88' `88b `888""8P d88' `"Y8 d88' `88b 
	  .oP"888  888   888  888   888   888    "    888   888  888     888       888ooo888 
	 d8(  888  888   888  888   888   888         888   888  888     888   .o8 888    .o 
	 `Y888""8o `Y8bod88P" `Y8bod88P" o888o        `Y8bod8P' d888b    `Y8bod8P' `Y8bod8P' 
	*/
	public function addForce($jobID = null)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "add"]);
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/payrolls/", __("Hours")],
			[null, "Forcibly Add Hours"]
		]);

		$payroll = $this->Payrolls->newEntity();
		if ($this->request->is('post')) {

			$fixed_data = array_merge($this->request->getData(), [
				'is_paid' => 0
			]);

			if ( $this->CONFIG_DATA['require-hours'] ) {
				$fixed_data['time_start']   = Chronos::createFromFormat('H:i', $this->request->getData('time_start'));
				$fixed_data['time_end']     = Chronos::createFromFormat('H:i', $this->request->getData('time_end'));
				$fixed_data['hours_worked'] = ($fixed_data['time_end']->diffInMinutes($fixed_data['time_start']) / 60);
			} else {
				$fixed_data['time_start'] = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = $fixed_data["time_end"]->addMinutes(intval($fixed_data["hours_worked"] * 60));
			}

			$payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
			if ($this->Payrolls->save($payroll)) {
				$this->Flash->success(__('The payroll has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The payroll could not be saved. Please, try again.'));
		}

		$this->loadModel("Users");
		$users = $this->Users->find('list', [
				'keyField' => 'id',
				'valueField' => function ($row) {
					return $row['last'] . ', ' . $row['first'];
				}
			])
			->where([ "is_active" => 1 ])
			->order([ "last" => "ASC", "first" => "ASC" ]);

		if ( !is_null($jobID) ) {
			$job = $this->loadModel("Jobs")->get($jobID);

			$jobs = [ $job->id => $job->name ];
		} else {

			$jobs_sch = $this->Payrolls->Jobs->find("activeOpenList", [
				'keyField'   => 'id',
				'valueField' => 'name'
			]);

			$jobs = $jobs_sch->toArray();
		}
		
		if ( count($jobs) < 1 ) {
			$this->Flash->error(__('Unable to find any jobs'));
			return $this->redirect(['controller' => 'jobs', 'action' => 'index']);
		}

		$this->set(compact('payroll', 'users', 'jobs'));
		
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
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		$payroll = $this->Payrolls->get($id, [
			'contain' => ["Users","Jobs"]
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$fixed_data = $this->request->getData();

			if ( $this->CONFIG_DATA['require-hours'] ) {
				$fixed_data['time_start']   = Chronos::createFromFormat('H:i', $this->request->getData('time_start'));
				$fixed_data['time_end']     = Chronos::createFromFormat('H:i', $this->request->getData('time_end'));
				$fixed_data['hours_worked'] = ($fixed_data['time_end']->diffInMinutes($fixed_data['time_start']) / 60);
			} else {
				$fixed_data['time_start'] = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = Chronos::createFromFormat('H:i', "0:00");
				$fixed_data['time_end']   = $fixed_data["time_end"]->addMinutes(intval($fixed_data["hours_worked"] * 60));
			}

			$payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
			if ($this->Payrolls->save($payroll)) {
				$this->Flash->success(__('The payroll has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The payroll could not be saved. Please, try again.'));
		}
		$users = [ $payroll->user->id => $payroll->user->last . ", " . $payroll->user->first ];
		$jobs  = [ $payroll->job->id => $payroll->job->name ];
		
		$this->set(compact('payroll', 'users', 'jobs'));
	}


	
	/*
	       .o8            oooo                .             
	      "888            `888              .o8             
	  .oooo888   .ooooo.   888   .ooooo.  .o888oo  .ooooo.  
	 d88' `888  d88' `88b  888  d88' `88b   888   d88' `88b 
	 888   888  888ooo888  888  888ooo888   888   888ooo888 
	 888   888  888    .o  888  888    .o   888 . 888    .o 
	 `Y8bod88P" `Y8bod8P' o888o `Y8bod8P'   "888" `Y8bod8P' 
	*/
	public function delete($id = null)
	{
		
		$payroll = $this->Payrolls->get($id);

		if ( $payroll->is_paid ) {
			$this->Flash->error("Only unpaid entries may be deleted, sorry.");
			return $this->redirect(["action" => "index"]);
		}
		if ( !$this->Auth->user('is_admin') && $payroll->user_id <> $this->Auth->user("id")) {
			$this->Flash->error("You may only delete your own entries.");
			return $this->redirect(["action" => "index"]);
		}

		if ($this->Payrolls->delete($payroll)) {
			$this->Flash->success(__('The payroll has been deleted.'));
		} else {
			$this->Flash->error(__('The payroll could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}



	/*
	                                      oooo        ooooooooo.              o8o        .o8  
	                                      `888        `888   `Y88.            `"'       "888  
	 ooo. .oo.  .oo.    .oooo.   oooo d8b  888  oooo   888   .d88'  .oooo.   oooo   .oooo888  
	 `888P"Y88bP"Y88b  `P  )88b  `888""8P  888 .8P'    888ooo88P'  `P  )88b  `888  d88' `888  
	  888   888   888   .oP"888   888      888888.     888          .oP"888   888  888   888  
	  888   888   888  d8(  888   888      888 `88b.   888         d8(  888   888  888   888  
	 o888o o888o o888o `Y888""8o d888b    o888o o888o o888o        `Y888""8o o888o `Y8bod88P" 
	*/
	public function markPaid($id = null) {
		$this->RequestHandler->renderAs($this, 'json');
		$this->set('success', false);

		if ( !$this->Auth->user('is_admin') ) {
			$this->set('responseString', "You do not have access to do this!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}

		if ( is_null($id) ) {
			$this->set('responseString', "Invalid action!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}

		$payroll = $this->Payrolls->get($id);

		if ( ! $payroll ) {
			$this->set('responseString', "Record not found!");
			$this->set('_serialize', ['responseString', 'success']);
			return;
		}

		$payroll->is_paid = 1;
		$this->set('pillID', "mark-" . $payroll->id);

		if ( $this->Payrolls->save($payroll) ) {
			$this->set('success', true);
			$this->set('responseString', "Worked");
			$this->set('_serialize', ['responseString', 'success', 'pillID']);
		} else {
			$this->set('responseString', "Save failed!");
			$this->set('_serialize', ['responseString', 'success']);
		}
	}



	/*
	                                      oooo              .o.       oooo  oooo  
	                                      `888             .888.      `888  `888  
	 ooo. .oo.  .oo.    .oooo.   oooo d8b  888  oooo      .8"888.      888   888  
	 `888P"Y88bP"Y88b  `P  )88b  `888""8P  888 .8P'      .8' `888.     888   888  
	  888   888   888   .oP"888   888      888888.      .88ooo8888.    888   888  
	  888   888   888  d8(  888   888      888 `88b.   .8'     `888.   888   888  
	 o888o o888o o888o `Y888""8o d888b    o888o o888o o88o     o8888o o888o o888o 
	*/
	function markAll() {
		$this->request->allowMethod(['post', 'delete']);

		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}

		$updateList = $this->request->getData('unpaidid');

		if ( count($updateList) < 1 ) {
			$this->Flash->error("No records found");
			return $this->redirect(["action" => "index"]);
		}

		$this->Payrolls->updateAll(
			[  // fields
				'is_paid' => 1,
			],
			[  // conditions
				'id IN' => $updateList
			]
		);

		$this->Flash->success("Records marked paid");
		return $this->redirect(["action" => "index"]);
	}


	/*
	  .o8                   ooooo     ooo                             
	 "888                   `888'     `8'                             
	  888oooo.  oooo    ooo  888       8   .oooo.o  .ooooo.  oooo d8b 
	  d88' `88b  `88.  .8'   888       8  d88(  "8 d88' `88b `888""8P 
	  888   888   `88..8'    888       8  `"Y88b.  888ooo888  888     
	  888   888    `888'     `88.    .8'  o.  )88b 888    .o  888     
	  `Y8bod8P'     .8'        `YbodP'    8""888P' `Y8bod8P' d888b    
	            .o..P'                                                
	            `Y8P'                                                 
	*/
	function byUser() {
		if ( !$this->Auth->user('is_admin') ) {
			return $this->redirect(["action" => "mine"]);
		}

		$this->loadModel("Users");
		$users = $this->Users->find("all")->where(["is_active" => 1])->order(['last' => 'ASC','first' => 'asc']);

		$this->set('lister', $users);
		$this->set('action', 'user');
		$this->set('title', "View Payroll By User");

		$this->render("lister");
	}



	/*
	  .o8                      oooo            .o8       
	 "888                      `888           "888       
	  888oooo.  oooo    ooo     888  .ooooo.   888oooo.  
	  d88' `88b  `88.  .8'      888 d88' `88b  d88' `88b 
	  888   888   `88..8'       888 888   888  888   888 
	  888   888    `888'        888 888   888  888   888 
	  `Y8bod8P'     .8'     .o. 88P `Y8bod8P'  `Y8bod8P' 
	            .o..P'      `Y888P                       
	            `Y8P'                                    
	*/
	function byJob() {
		$this->loadModel("Jobs");
		$jobs = $this->Jobs->find("all")->where(["is_open" => 1, "is_active" => 1])->order(['date_start' => 'DESC','name' => 'asc']);

		$this->set('lister', $jobs);
		$this->set('action', 'job');
		$this->set('title', "View Payroll By Job");

		$this->render("lister");
	}
}
