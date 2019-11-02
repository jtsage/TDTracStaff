<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jobs Model
 *
 * @property \App\Model\Table\PayrollsTable|\Cake\ORM\Association\HasMany $Payrolls
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsToMany $Roles
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Job get($primaryKey, $options = [])
 * @method \App\Model\Entity\Job newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Job[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Job|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Job saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Job patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Job[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Job findOrCreate($search, callable $callback = null, $options = [])
 */
class JobsTable extends Table
{
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setTable('jobs');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->hasMany('Payrolls', [
			'foreignKey' => 'job_id'
		]);
		$this->belongsToMany('Roles', [
			'foreignKey' => 'job_id',
			'targetForeignKey' => 'role_id',
			'joinTable' => 'jobs_roles'
		]);
		$this->belongsToMany('Users', [
			'foreignKey' => 'job_id',
			'targetForeignKey' => 'user_id',
			'joinTable' => 'users_jobs'
		]);
		$this->addBehavior('Timestamp', [
			'events' => [
				'Model.beforeSave' => [
					'created_at' => 'new',
					'updated_at' => 'always',
				],
				'Users.afterLogin' => [
					'last_login_at' => 'always'
				]
			]
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator)
	{
		$validator
			->uuid('id')
			->allowEmptyString('id', 'create');

		$validator
			->scalar('name')
			->maxLength('name', 60)
			->requirePresence('name', 'create')
			->allowEmptyString('name', false);

		$validator
			->scalar('detail')
			->maxLength('detail', 60)
			->allowEmptyString('detail');

		$validator
			->scalar('location')
			->maxLength('location', 150)
			->allowEmptyString('location');

		$validator
			->scalar('category')
			->maxLength('category', 50)
			->allowEmptyString('category');

		$validator
			->date('date_start')
			->requirePresence('date_start', 'create')
			->allowEmptyDate('date_start', false);

		$validator
			->date('date_end')
			->requirePresence('date_end', 'create')
			->allowEmptyDate('date_end', false);

		$validator
			->scalar('time_string')
			->maxLength('time_string', 250)
			->requirePresence('time_string', 'create')
			->allowEmptyString('time_string', false);

		$validator
			->boolean('is_active')
			->allowEmptyString('is_active', false);

		$validator
			->boolean('is_open')
			->allowEmptyString('is_open', false);

		$validator
			->dateTime('created_at')
			->allowEmptyDateTime('created_at', false);

		$validator
			->dateTime('updated_at')
			->allowEmptyDateTime('updated_at', false);

		return $validator;
	}
}