<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

	/*
	                             .o.                       .   oooo        
	                            .888.                    .o8   `888        
	 ooo. .oo.    .ooooo.      .8"888.     oooo  oooo  .o888oo  888 .oo.   
	 `888P"Y88b  d88' `88b    .8' `888.    `888  `888    888    888P"Y88b  
	  888   888  888   888   .88ooo8888.    888   888    888    888   888  
	  888   888  888   888  .8'     `888.   888   888    888 .  888   888  
	 o888o o888o `Y8bod8P' o88o     o8888o  `V88V"V8P'   "888" o888o o888o 
	*/
	public function beforeFilter(\Cake\Event\Event $event)
	{
		$this->Auth->allow(['logout', 'forgotPassword', 'resetPassword', 'verify']);
	}



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
			return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
		}
		$this->paginate = [
			'order' => [
				'Users.last' => 'ASC',
				'Users.first' => 'ASC'
			]
		];

		$this->set('crumby', [
			["/", "Dashboard"],
			[null, "User List"]
		]);

		$this->set('users', $this->paginate($this->Users, ["contain" => [ "Roles" => ['sort' => ['Roles.sort_order' => 'ASC']]]]));
		$this->set('_serialize', ['users']);


		$this->set('tz', $this->CONFIG_DATA['time-zone']);
	}



	/*
	 oooo                        o8o              
	 `888                        `"'              
	  888   .ooooo.   .oooooooo oooo  ooo. .oo.   
	  888  d88' `88b 888' `88b  `888  `888P"Y88b  
	  888  888   888 888   888   888   888   888  
	  888  888   888 `88bod8P'   888   888   888  
	 o888o `Y8bod8P' `8oooooo.  o888o o888o o888o 
	                 d"     YD                    
	                 "Y88888P'                    
	*/
	public function login()
	{
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				
				$goodUser = $this->Users->get($this->Auth->user('id'));
				
				$this->Users->touch($goodUser, 'Users.afterLogin');
				$goodUser->reset_hash = null;
				$goodUser->reset_hash_time = date('Y-m-d H:i:s', 1);
				$this->Users->save($goodUser);

				$this->set('UserTemp', $this->Auth->user('is_active'));

				if ( $this->Auth->user('is_password_expired')) {
					$this->Flash->error(__("Your password has expired, please change it!"));
					return $this->redirect(['controller' => 'Users', 'action' => 'changepass', $this->Auth->user('id')]); 
				}

				if ( ! $this->Auth->user('is_active')) {
					$this->Flash->error(__("Your account is disabled, please contact your system administrator"));
					return $this->redirect($this->Auth->logout());
				}

				if ( ! $this->Auth->user('is_verified')) {
					$this->Flash->error(__("Your account is not yet verified, please check your e-mail for details."));
					return $this->redirect($this->Auth->logout());
				}

				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Your username or password is incorrect.');
		}
	}



	/*
	 oooo                                                 .   
	 `888                                               .o8   
	  888   .ooooo.   .oooooooo  .ooooo.  oooo  oooo  .o888oo 
	  888  d88' `88b 888' `88b  d88' `88b `888  `888    888   
	  888  888   888 888   888  888   888  888   888    888   
	  888  888   888 `88bod8P'  888   888  888   888    888 . 
	 o888o `Y8bod8P' `8oooooo.  `Y8bod8P'  `V88V"V8P'   "888" 
	                 d"     YD                                
	                 "Y88888P'                                
	*/
	public function logout()
	{
		$this->Flash->success(__('You are now logged out.'));
		return $this->redirect($this->Auth->logout());
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
		if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
			$this->Flash->error(__('You may only view and edit your own user record. (Loaded)'));
			return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
		}
		$user = $this->Users->get($id, [
			'contain' => ['Roles']
		]);

		if ( $this->Auth->user('is_admin')) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/users/", __("Users")],
				[null, $user->first . " " . $user->last]
			]);
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				[null, __("Your Profile")]
			]);
		}

		$this->set('user', $user);
		$this->set('_serialize', ['user']);
		$this->set('tz', $this->CONFIG_DATA['time-zone']);
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
			$this->Flash->error(__('You may not add users'));
			return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
		}
		$this->set("C2", $this->CONFIG_DATA);
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());

			$user->is_verified = 1;
			$user->is_password_expired = 1;

			$this->loadModel("MailQueues");
			
			if ( $this->request->getData('welcomeEmailSend') ) {
				
				$thisMail = $this->MailQueues->newEntity([
					"template" => "default",
					"toUser"   => $user->username,
					"subject"  => "Welcome to TDTracStaff",
					"viewvars" => json_encode(['CONFIG' => $this->CONFIG_DATA]),
					"body"     => preg_replace("/\\n/", "<br />\n", $this->request->getData('welcomeEmail'))
				]);
				
				if ( $this->CONFIG_DATA["queue-email"] ) {
					if ( $this->MailQueues->save($thisMail) ) {
						$this->Flash->success(__('Welcome E-Mail Added to Queue'));
					} else {
						$this->Flash->error('Mail Queue Error: ' . var_export($thisMail->errors(),true));
					}
				} else {
					$email = new Email('default');
					$email
						->template($thisMail->template)
						->setTo($thisMail->toUser)
						->setSubject($thisMail->subject)
						->setViewVars(json_decode($thisMail->viewvars, true));
					$email->send($thisMail->body);
				}
			}
			if ( $this->request->getData('welcomeEmailSendCopy') ) {
				$thisMail = $this->MailQueues->newEntity([
					"template" => "default",
					"toUser"   => rtrim($this->CONFIG_DATA["admin-email"]),
					"subject"  => "Welcome to TDTracStaff - " . $this->request->getData('first') . " " .  $this->request->getData('last'),
					"viewvars" => json_encode(['CONFIG' => $this->CONFIG_DATA]),
					"body"     => preg_replace("/\\n/", "<br />\n", $this->request->getData('welcomeEmail'))
				]);

				if ( $this->CONFIG_DATA["queue-email"] ) {
					if ( $this->MailQueues->save($thisMail) ) {
						$this->Flash->success(__('Welcome E-Mail Copy Added to Queue'));
					} else {
						$this->Flash->error('Mail Queue Error: ' . var_export($thisMail->errors(),true));
					}
				} else {
					$email = new Email('default');
					$email
						->template($thisMail->template)
						->setTo($thisMail->toUser)
						->setSubject($thisMail->subject)
						->setViewVars(json_decode($thisMail->viewvars, true));
					$email->send($thisMail->body);
				}
			}

			if (true ){//$this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}

		$this->set('crumby', [
			["/", __("Dashboard")],
			["/users/", __("Users")],
			[null, __("Add User")]
		]);
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
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
		if ( ! $this->Auth->user('is_admin') ) {
			if ( $id <> $this->Auth->user('id') ) {
				$this->Flash->error(__('You may only change your own user record. (Loaded)'));
			}
			return $this->redirect(['action' => 'safeedit', $this->Auth->user('id')]);
		}
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/users/", __("Users")],
			["/users/view/" . $user->id, $user->first . " " . $user->last],
			[null, __("Edit User")]
		]);
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}


	/*
	                     .o88o.           oooooooooooo       .o8   o8o      .   
	                     888 `"           `888'     `8      "888   `"'    .o8   
	  .oooo.o  .oooo.   o888oo   .ooooo.   888          .oooo888  oooo  .o888oo 
	 d88(  "8 `P  )88b   888    d88' `88b  888oooo8    d88' `888  `888    888   
	 `"Y88b.   .oP"888   888    888ooo888  888    "    888   888   888    888   
	 o.  )88b d8(  888   888    888    .o  888       o 888   888   888    888 . 
	 8""888P' `Y888""8o o888o   `Y8bod8P' o888ooooood8 `Y8bod88P" o888o   "888" 
	*/
	public function safeedit($id = null)
	{
		if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
			$this->Flash->error(__('You may edit your own user record. (Loaded)'));
			return $this->redirect(['action' => 'safeedit', $this->Auth->user('id')]);
		}
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData(), [
				'field' => ['first', 'last', 'print_name']
			]);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->set('crumby', [
			["/", __("Dashboard")],
			["/users/view/" . $user->id, __("Your Profile")],
			[null, __("Edit Profile")]
		]);
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}

	/*
	           oooo                               ooooooooo.                               
	           `888                               `888   `Y88.                             
	  .ooooo.   888 .oo.   ooo. .oo.    .oooooooo  888   .d88'  .oooo.    .oooo.o  .oooo.o 
	 d88' `"Y8  888P"Y88b  `888P"Y88b  888' `88b   888ooo88P'  `P  )88b  d88(  "8 d88(  "8 
	 888        888   888   888   888  888   888   888          .oP"888  `"Y88b.  `"Y88b.  
	 888   .o8  888   888   888   888  `88bod8P'   888         d8(  888  o.  )88b o.  )88b 
	 `Y8bod8P' o888o o888o o888o o888o `8oooooo.  o888o        `Y888""8o 8""888P' 8""888P' 
	                                   d"     YD                                           
	                                   "Y88888P'                                           
	*/
	public function changepass($id = null)
	{
		if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
			$this->Flash->error(__('You may only change your own password. (Loaded)'));
			return $this->redirect(['action' => 'changepass', $this->Auth->user('id')]);
		}
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData(), ['field' => ['password', 'is_password_expired']]);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		if ( $this->Auth->user('is_admin') ) {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/users/", __("User List")],
				["/users/view/" . $user->id, $user->first . " " . $user->last],
				[null, __("Change Password")]
			]);
		} else {
			$this->set('crumby', [
				["/", __("Dashboard")],
				["/users/view/" . $user->id, __("Your Profile")],
				[null, __("Change Your Password")]
			]);
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
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
		if ( ! $this->Auth->user('is_admin')) {
			$this->Flash->error(__('You may not delete users'));
			return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
		}
		
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}

	/*
	                                        ooooooooooooo           oooo                              
	                                        8'   888   `8           `888                              
	 oo.ooooo.   .oooo.    .oooo.o  .oooo.o      888       .ooooo.   888  oooo   .ooooo.  ooo. .oo.   
	  888' `88b `P  )88b  d88(  "8 d88(  "8      888      d88' `88b  888 .8P'   d88' `88b `888P"Y88b  
	  888   888  .oP"888  `"Y88b.  `"Y88b.       888      888   888  888888.    888ooo888  888   888  
	  888   888 d8(  888  o.  )88b o.  )88b      888      888   888  888 `88b.  888    .o  888   888  
	  888bod8P' `Y888""8o 8""888P' 8""888P'     o888o     `Y8bod8P' o888o o888o `Y8bod8P' o888o o888o 
	  888                                                                                             
	 o888o                                                                                            
	*/
	function __genPassToken($user) {
		if (empty($user)) { return null; }
		
		$token_raw = random_bytes(30);
		$token_hex = bin2hex($token_raw);


		$token_expire_timestamp = time() + (60*60*24);
		$token_expire = date('Y-m-d H:i:s', $token_expire_timestamp);
		
		$user->reset_hash = $token_hex;
		$user->reset_hash_time = $token_expire;
		
		return $user;
	}

	/*
	                                 .o88o. ooooooooooooo           oooo                              
	                                 888 `" 8'   888   `8           `888                              
	 oooo    ooo  .ooooo.  oooo d8b o888oo       888       .ooooo.   888  oooo   .ooooo.  ooo. .oo.   
	  `88.  .8'  d88' `88b `888""8P  888         888      d88' `88b  888 .8P'   d88' `88b `888P"Y88b  
	   `88..8'   888ooo888  888      888         888      888   888  888888.    888ooo888  888   888  
	    `888'    888    .o  888      888         888      888   888  888 `88b.  888    .o  888   888  
	     `8'     `Y8bod8P' d888b    o888o       o888o     `Y8bod8P' o888o o888o `Y8bod8P' o888o o888o 
	*/
	function __genVerifyToken($user) {
		if (empty($user)) { return null; }
		
		$token_raw = random_bytes(30);
		$token_hex = bin2hex($token_raw);

		$user->verify_hash = $token_hex;
		$user->is_verified = 0;
		$user->is_admin = 0;
		
		return $user;
	}



	/*
	  .o88o.                                             .   
	  888 `"                                           .o8   
	 o888oo   .ooooo.  oooo d8b  .oooooooo  .ooooo.  .o888oo 
	  888    d88' `88b `888""8P 888' `88b  d88' `88b   888   
	  888    888   888  888     888   888  888   888   888   
	  888    888   888  888     `88bod8P'  888   888   888 . 
	 o888o   `Y8bod8P' d888b    `8oooooo.  `Y8bod8P'   "888" 
	                            d"     YD                    
	                            "Y88888P'                    
	*/
	function forgotPassword() {
		if ( ! is_null($this->Auth->user('id'))) {
			$this->Flash->error(__('You have not forgotten your password, you are logged in.'));
			return $this->redirect('/');
		}
		if ($this->request->is(['post']) && !empty( $this->request->getData('username') ) ) {

			$userReset = $this->Users->findByUsername($this->request->getData('username'))->first();

			if ( empty($userReset) ) {
				$this->Flash->error(__('Password reset instructions sent.  You have 24 hours to complete this request.'));
				return $this->redirect('/');
			} else {
				$userReset = $this->__genPassToken($userReset);
				if ( $this->Users->save($userReset) ) {
					$email = new Email('default');
					$email
						->template('reset')
						->setEmailFormat('html')
						->setTo($userReset->username)
						->setSubject('Password Reset Requested')
						->setViewVars([
							'username' => $userReset->username,
							'ip' => $_SERVER['REMOTE_ADDR'],
							'hash' => $userReset->reset_hash,
							'expire' => $userReset->reset_hash_time,
							'fullURL' => $this->CONFIG_DATA['server-name'] . "/users/reset_password/",
							'CONFIG' => $this->CONFIG_DATA
						])
						->send();

					$this->Flash->error(__('Password reset instructions sent.  You have 24 hours to complete this request.'));
					return $this->redirect('/');
				}
			}
		}
	}


	/*
	                                o8o               .                      
	                                `"'             .o8                      
	 oooo d8b  .ooooo.   .oooooooo oooo   .oooo.o .o888oo  .ooooo.  oooo d8b 
	 `888""8P d88' `88b 888' `88b  `888  d88(  "8   888   d88' `88b `888""8P 
	  888     888ooo888 888   888   888  `"Y88b.    888   888ooo888  888     
	  888     888    .o `88bod8P'   888  o.  )88b   888 . 888    .o  888     
	 d888b    `Y8bod8P' `8oooooo.  o888o 8""888P'   "888" `Y8bod8P' d888b    
	                    d"     YD                                            
	                    "Y88888P'                                            
	*/
	public function register()
	{
		$this->Flash->error(__('Feature DISABLED - UNSAFE FOR THIS APPLICATION!'));
		return $this->redirect('/');
	}



	/*
	                                           .   ooooooooo.                               
	                                         .o8   `888   `Y88.                             
	 oooo d8b  .ooooo.   .oooo.o  .ooooo.  .o888oo  888   .d88'  .oooo.    .oooo.o  .oooo.o 
	 `888""8P d88' `88b d88(  "8 d88' `88b   888    888ooo88P'  `P  )88b  d88(  "8 d88(  "8 
	  888     888ooo888 `"Y88b.  888ooo888   888    888          .oP"888  `"Y88b.  `"Y88b.  
	  888     888    .o o.  )88b 888    .o   888 .  888         d8(  888  o.  )88b o.  )88b 
	 d888b    `Y8bod8P' 8""888P' `Y8bod8P'   "888" o888o        `Y888""8o 8""888P' 8""888P' 
	*/
	function resetPassword($hash) {
		if ( ! is_null($this->Auth->user('id'))) {
			$this->Flash->error(__('You have not forgotten your password, you are logged in.'));
			return $this->redirect('/');
		}
		if ( empty($hash) ) {
			$this->Flash->error(__('That link is invalid, sorry!'));
			return $this->redirect('/');
		} else {
			$user = $this->Users->findByResetHash($hash)->first();
			if ( empty($user) ) {
				$this->Flash->error(__('That link is invalid, sorry!'));
				return $this->redirect('/');
			} elseif ( $user->reset_hash_time->isPast() ) {
				$this->Flash->error(__('That Link has expired, sorry!'));
				return $this->redirect('/users/forgot_password');
			} else {
				$this->set('user', $user);    
				if ($this->request->is(['patch', 'post', 'put'])) {
					$user = $this->Users->patchEntity($user, $this->request->getData(), ['fields' => ['password', 'is_password_expired']]);
					$user->reset_hash = null;
					$user->reset_hash_time = date('Y-m-d H:i:s', 1);
					if ($this->Users->save($user)) {
						$this->Flash->success(__('Your password has been saved, please login now.'));
						return $this->redirect('/users/login');
					} else {
						$this->Flash->error(__('The user could not be saved. Please, try again.'));
					}
				}
			}   
		}
	}

	/*
	                                 o8o   .o88o.             
	                                 `"'   888 `"             
	 oooo    ooo  .ooooo.  oooo d8b oooo  o888oo  oooo    ooo 
	  `88.  .8'  d88' `88b `888""8P `888   888     `88.  .8'  
	   `88..8'   888ooo888  888      888   888      `88..8'   
	    `888'    888    .o  888      888   888       `888'    
	     `8'     `Y8bod8P' d888b    o888o o888o       .8'     
	                                              .o..P'      
	                                              `Y8P'       
	*/
	function verify($hash) {
		if ( ! is_null($this->Auth->user('id'))) {
			$this->Flash->error(__('You have not forgotten your password, you are logged in.'));
			return $this->redirect('/');
		}
		if ( empty($hash) ) {
			$this->Flash->error(__('That link is invalid, sorry!'));
			return $this->redirect('/');
		} else {
			$user = $this->Users->findByVerifyHash($hash)->first();
			if ( empty($user) ) {
				$this->Flash->error(__('That link is invalid, sorry!'));
				return $this->redirect('/');
			} else {
				$user->is_verified = 1;
				$user->verify_hash = null;

				if ( $this->Users->save($user) ) {
					$this->Flash->success(__('Account activated, please login now.'));
					return $this->redirect('/users/login');
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
					return $this->redirect('/');
				}
			}
		}
	}

	/*
	                    oooo                     
	                    `888                     
	 oooo d8b  .ooooo.   888   .ooooo.   .oooo.o 
	 `888""8P d88' `88b  888  d88' `88b d88(  "8 
	  888     888   888  888  888ooo888 `"Y88b.  
	  888     888   888  888  888    .o o.  )88b 
	 d888b    `Y8bod8P' o888o `Y8bod8P' 8""888P' 
	*/
	function roles($id)
	{
		if ( !$this->Auth->user('is_admin') ) {
			$this->Flash->error("Sorry, you do not have access to this module.");
			return $this->redirect(["action" => "index"]);
		}
		if ( !$this->request->is(['patch','post','put'])) {
			$user = $this->Users->get($id);

			$this->loadModel("Roles");
			$this->loadModel("UsersRoles");

			$inRoles = $this->UsersRoles->find("all")->where(["user_id" => $id]);
			$userRoles = [];
			foreach ( $inRoles as $thisRole ) {
				$userRoles[] = $thisRole->role_id;
			}

			$roles = $this->Roles->find("all")->order(["sort_order" => "ASC"]);

			$this->set('current', $userRoles);
			$this->set('roles', $roles);
			$this->set('user', $user);

			$this->set('crumby', [
				["/", __("Dashboard")],
				["/users/", __("Users")],
				["/users/view/" . $user->id, $user->first . " " . $user->last],
				[null, __("Edit User Training")]
			]);
		} else {
			$inserts = [];
			foreach ( $this->request->getData("role") as $roleID ) {
				$inserts[] = [
					'user_id' => $id,
					'role_id' => $roleID
				];
			}
			//debug($inserts);
			//debug($this->request->getData());
			$this->loadModel("UsersRoles");

			$this->UsersRoles->deleteAll([
				"user_id" => $id
			]);

			$entities = $this->UsersRoles->newEntities($inserts);
			$result   = $this->UsersRoles->saveMany($entities);
			$this->Flash->success("Staff training updated");
			return $this->redirect(["action" => "view", $id]);
		}
	}


}
