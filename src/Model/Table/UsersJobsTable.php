<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersJobs Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\JobsTable|\Cake\ORM\Association\BelongsTo $Jobs
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\UsersJob get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersJob newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersJob[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersJob|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersJob saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersJob patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersJob[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersJob findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersJobsTable extends Table
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

		$this->setTable('users_jobs');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Jobs', [
			'foreignKey' => 'job_id',
			'joinType' => 'INNER'
		]);
		$this->belongsTo('Roles', [
			'foreignKey' => 'role_id',
			'joinType' => 'INNER'
		]);
	}

	public function findMine(Query $query, array $options)
	{
		$where = ["user_id" => $options["userID"]];

		if ( !empty($options["true_filter"]) ) {
			$where[$options["true_filter"]] = 1;
		}
		return $query->distinct(["job_id"])->select(["job_id"])->where($where);
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
			->nonNegativeInteger('id')
			->allowEmptyString('id', 'create');

		$validator
			->allowEmptyString('is_available', false);

		$validator
			->allowEmptyString('is_scheduled', false);

		$validator
			->scalar('note')
			->maxLength('note', 250)
			->allowEmptyString('note');

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		$rules->add($rules->existsIn(['job_id'], 'Jobs'));
		$rules->add($rules->existsIn(['role_id'], 'Roles'));

		return $rules;
	}
}
