<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * JobsRoles Model
 *
 * @property \App\Model\Table\JobsTable|\Cake\ORM\Association\BelongsTo $Jobs
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\JobsRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\JobsRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JobsRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobsRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JobsRole saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JobsRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JobsRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobsRole findOrCreate($search, callable $callback = null, $options = [])
 */
class JobsRolesTable extends Table
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

		$this->setTable('jobs_roles');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

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
		$userRolesTable = TableRegistry::get('UsersRoles');
		

		$query->select(["job_id"]);
		$query->where([
			"role_id IN" => $userRolesTable->find("mine", $options)
		]);
		return $query;
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
			->integer('number_needed')
			->allowEmptyString('number_needed', false);

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
		$rules->add($rules->existsIn(['job_id'], 'Jobs'));
		$rules->add($rules->existsIn(['role_id'], 'Roles'));

		return $rules;
	}
}
