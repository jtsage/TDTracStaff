<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \App\Model\Table\UsersJobsTable|\Cake\ORM\Association\HasMany $UsersJobs
 * @property \App\Model\Table\JobsTable|\Cake\ORM\Association\BelongsToMany $Jobs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Role get($primaryKey, $options = [])
 * @method \App\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 */
class RolesTable extends Table
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

		$this->setTable('roles');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->hasMany('UsersJobs', [
			'foreignKey' => 'role_id'
		]);
		$this->belongsToMany('Jobs', [
			'foreignKey' => 'role_id',
			'targetForeignKey' => 'job_id',
			'joinTable' => 'jobs_roles'
		]);
		$this->belongsToMany('Users', [
			'foreignKey' => 'role_id',
			'targetForeignKey' => 'user_id',
			'joinTable' => 'users_roles'
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
			->scalar('title')
			->maxLength('title', 100)
			->requirePresence('title', 'create')
			->allowEmptyString('title', false);

		$validator
			->scalar('detail')
			->maxLength('detail', 255)
			->requirePresence('detail', 'create')
			->allowEmptyString('detail', false);

		$validator
			->dateTime('created_at')
			->allowEmptyDateTime('created_at', false);

		$validator
			->dateTime('updated_at')
			->allowEmptyDateTime('updated_at', false);

		return $validator;
	}
}
