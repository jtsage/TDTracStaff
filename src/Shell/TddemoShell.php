<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\InternalErrorException;
//use Cake\I18n\Time;
//use Cake\Mailer\Email;
//use Cake\ORM\TableRegistry;
//use Cake\Core\Configure;
//use Cake\Chronos\Chronos;

/**
 * Theater Bio shell command.
 */
class TddemoShell extends Shell
{

	public function getOptionParser()
	{
		$parser = parent::getOptionParser();
		$parser
			->setDescription('A small set of utilities to streamline the TDTracStaff demo')
			->addSubcommand('adduser', [
				'help' => 'Add a user',
				'parser' => [
					'description' => 'Add a user to the current system',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
						'NewPassword' => [ 'help' => 'The new password for the user', 'required' => true ],
						'FirstName' => [ 'help' => 'The first name of the user', 'required' => true ],
						'LastName' => [ 'help' => 'The last name of the user', 'required' => true ]
					],
					'options' => [
						'isAdmin' => [ 'short' => 'a', 'boolean' => true, 'help' => 'This user is an admin', 'default' => false ],
						'isBudget' => [ 'short' => 'b', 'boolean' => true, 'help' => 'This user keeps a budget', 'default' => false ]
					]
				]
			])
			->addSubcommand('resetpass', [
				'help' => 'Reset a user password',
				'parser' => [
					'description' => 'Reset a user\'s password',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
						'NewPassword' => [ 'help' => 'The new password for the user', 'required' => true ]
					]
				]
			])
			->addSubcommand('unban', [
				'help' => 'Make a user active',
				'parser' => [
					'description' => 'Mark a user as active, allowing login',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
					]
				]
			])
			->addSubcommand('ban', [
				'help' => 'Make a user inactive',
				'parser' => [
					'description' => 'Mark a user as inactive, preventing login',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
					]
				]
			])
			->addSubcommand('budget', [
				'help' => 'Toggle a user\'s budget status',
				'parser' => [
					'description' => 'Mark a user as budget user, or remove it',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
					]
				]
			])
			->addSubcommand('admin', [
				'help' => 'Toggle a user\'s admin status',
				'parser' => [
					'description' => 'Mark a user as administrator, or remove it',
					'arguments' => [
						'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
					]
				]
			]);
		return $parser;
	}
	/**
	 * main() method.
	 *
	 * @return bool|int Success or error code.
	 */
	public function main() 
	{
		return $this->out($this->getOptionParser()->help());
	}

	public function resetpass($user, $pass)
	{
		$this->loadModel('Users');

		if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
			$this->out('Changing password for: ' . $thisUser->first . " " . $thisUser->last);
			$thisUser->password = $pass;
			if ( $this->Users->save($thisUser) ) {
				$this->out('New password saved');
			} else {
				$this->out('Unable to update password');
			}
		} else {
			$this->err('User not found');
		}
	}

	public function unban($user)
	{
		$this->loadModel('Users');

		if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
			$this->out('Setting user active: ' . $thisUser->first . " " . $thisUser->last);
			$thisUser->is_active = 1;
			if ( $this->Users->save($thisUser) ) {
				$this->out('User now active');
			} else {
				$this->out('Unable to update user');
			}
		} else {
			$this->err('User not found');
		}
	}

	public function ban($user)
	{
		$this->loadModel('Users');

		if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
			$this->out('Setting user inactive: ' . $thisUser->first . " " . $thisUser->last);
			$thisUser->is_active = 0;
			if ( $this->Users->save($thisUser) ) {
				$this->out('User now inactive');
			} else {
				$this->out('Unable to update user');
			}
		} else {
			$this->err('User not found');
		}
	}
	public function admin($user)
	{
		$this->loadModel('Users');

		if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
			if ( $thisUser->is_admin ) {
				$this->out('Removing admin flag: ' . $thisUser->first . " " . $thisUser->last);
				$thisUser->is_admin = 0;
			} else {
				$this->out('Adding admin flag: ' . $thisUser->first . " " . $thisUser->last);
				$thisUser->is_admin = 1;
			}
			if ( $this->Users->save($thisUser) ) {
				$this->out('Saved.');
			} else {
				$this->out('Unable to update user');
			}
		} else {
			$this->err('User not found');
		}
	}
	public function budget($user)
	{
		$this->loadModel('Users');

		if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
			if ( $thisUser->is_budget ) {
				$this->out('Removing budget flag: ' . $thisUser->first . " " . $thisUser->last);
				$thisUser->is_budget = 0;
			} else {
				$this->out('Adding budget flag: ' . $thisUser->first . " " . $thisUser->last);
				$thisUser->is_budget = 1;
			}
			if ( $this->Users->save($thisUser) ) {
				$this->out('Saved.');
			} else {
				$this->out('Unable to update user');
			}
		} else {
			$this->err('User not found');
		}
	}

	public function adduser($user, $pass, $first, $last) {
		$this->loadModel('Users');

		$thisUser = $this->Users->newEntity([
			'username'    => $user,
			'password'    => $pass,
			'first'       => $first,
			'last'        => $last,
			'is_verified' => 1,
			'is_admin'    => ($this->params['isAdmin'] ? 1:0 ),
			'is_budget'   => ($this->params['isBudget'] ? 1:0 ),
		]);

		if ( $this->Users->save($thisUser) ) {
			$this->out('Added user: ' . $thisUser->first . " " . $thisUser->last);
		} else {
			$this->err('Unable to add user');
		}
	}


	
}
