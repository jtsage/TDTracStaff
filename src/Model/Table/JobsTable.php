<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

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
			'joinTable' => 'users_jobs',
		]);

		$this->belongsToMany('UsersScheduled', [
			'foreignKey' => 'job_id',
			'targetForeignKey' => 'user_id',
			'joinTable' => 'users_jobs',
			'className' => 'Users',
			'propertyName' => "users_sch",
			'conditions' => ["UsersJobs.is_scheduled" => 1],
			'sort' => ["last" => "ASC", "first" => "ASC"]
		]);
		$this->belongsToMany('UsersInterested', [
			'foreignKey' => 'job_id',
			'targetForeignKey' => 'user_id',
			'joinTable' => 'users_jobs',
			'className' => 'Users',
			'propertyName' => "users_int",
			'conditions' => ["UsersJobs.is_available" => 1],
			'sort' => ["last" => "ASC", "first" => "ASC"]
		]);
		$this->belongsToMany('UsersBoth', [
			'foreignKey' => 'job_id',
			'targetForeignKey' => 'user_id',
			'joinTable' => 'users_jobs',
			'className' => 'Users',
			'propertyName' => "users_both",
			'conditions' => ["OR" => [ "UsersJobs.is_scheduled" => 1, "UsersJobs.is_available" => 1]],
			'sort' => ["last" => "ASC", "first" => "ASC"]
		]);
		$this->addBehavior('Timestamp', [
			'events' => [
				'Model.beforeSave' => [
					'created_at' => 'new',
					'updated_at' => 'always',
				]
			]
		]);
	}

	public function findActiveOpenList(Query $query, array $options)
	{
		$query->where(["is_open" => 1, "is_active" => 1]);
		$query->order(["date_start" => "DESC", "name" => "ASC"]);
		return $query->formatResults(function(\Cake\Datasource\ResultSetInterface $results) use ($options) {
		 	return $results->combine($options['keyField'], $options['valueField']);
		});
	}
	public function findDetailSubset(Query $query, array $options)
	{
		$jobsRolesTable = TableRegistry::get('JobsRoles');

		return $query
			->contain([
				"Roles" => [
					'sort' => ['Roles.sort_order' => 'ASC']
				],
				"UsersScheduled",
				"UsersInterested"
			])
			->where([
				"is_open"   => 1,
				"is_active" => 1,
				"id IN"     => $options['limitList']
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
