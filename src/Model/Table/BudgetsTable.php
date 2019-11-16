<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Budgets Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\JobsTable|\Cake\ORM\Association\BelongsTo $Jobs
 *
 * @method \App\Model\Entity\Budget get($primaryKey, $options = [])
 * @method \App\Model\Entity\Budget newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Budget[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Budget|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Budget saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Budget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Budget[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Budget findOrCreate($search, callable $callback = null, $options = [])
 */
class BudgetsTable extends Table
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

		$this->setTable('budgets');
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
	}

	public function findTotalList(Query $query, array $options)
	{
		$query->group(["job_id"]);

		$query->select([
			"job_id",
			"total" => $query->func()->sum("amount")
		]);
		
		return $query->formatResults(function(\Cake\Datasource\ResultSetInterface $results) use ($options) {
		 	return $results->combine('job_id', 'total');
		});
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
			->scalar('vendor')
			->maxLength('vendor', 150)
			->requirePresence('vendor', 'create')
			->allowEmptyString('vendor', false);

		$validator
			->scalar('category')
			->maxLength('category', 150)
			->requirePresence('category', 'create')
			->allowEmptyString('category', false);

		$validator
			->scalar('detail')
			->maxLength('detail', 255)
			->allowEmptyString('detail');

		$validator
			->date('date')
			->requirePresence('date', 'create')
			->allowEmptyDate('date', false);

		$validator
			->decimal('amount')
			->requirePresence('amount', 'create')
			->allowEmptyString('amount', false);

		$validator
			->dateTime('created_at')
			->allowEmptyDateTime('created_at', false);

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

		return $rules;
	}
}
