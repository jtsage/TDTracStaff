<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Expression\IdentifierExpression;

/**
 * Payrolls Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\JobsTable|\Cake\ORM\Association\BelongsTo $Jobs
 *
 * @method \App\Model\Entity\Payroll get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payroll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Payroll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payroll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payroll saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payroll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payroll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payroll findOrCreate($search, callable $callback = null, $options = [])
 */
class PayrollsTable extends Table
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

		$this->setTable('payrolls');
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
		$this->addBehavior('Timestamp', [
			'events' => [
				'Model.beforeSave' => [
					'created_at' => 'new',
					'updated_at' => 'always',
				]
			]
		]);
	}

	
	public function findListDetail(Query $query, array $options)
	{
		return $query->contain([
			"Users" => ["fields" => ["first", "last", "id"]],
			"Jobs" => ["fields" => ["id", "name"]]
		])
		->order([
			"Users.last" => "ASC",
			"date_worked" => "DESC",
			"Payrolls.created_at" => "DESC"
		]);
	}

	public function findUserTotals(Query $query, array $options)
	{
		//$user = $options['user'];
		
		$unPaidCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['is_paid' => '0']) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);
		$paidCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['is_paid' => '1']) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);

		if ( !empty($options['job_id']) ) {
			$query->where(["job_id" => $options['job_id']]);
		}
		$query->contain(["Users"]);

		return $query->select([
			"Users.last",
			"Users.first",
			'user_id',
			'total_worked' => $query->func()->sum('hours_worked'),
			'total_unpaid' => $query->func()->sum($unPaidCase),
			'total_paid' => $query->func()->sum($paidCase)
		])->group(["user_id"]);
	}

	public function findJobTotals(Query $query, array $options)
	{
		//$user = $options['user'];
		
		$unPaidCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['is_paid' => '0']) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);
		$paidCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['is_paid' => '1']) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);

		$query->contain(["Jobs"]);
		$query->where(["Jobs.is_open" => 1]);
			
		return $query->select([
			'job_id',
			"Jobs.name",
			"Jobs.is_active",
			'total_worked' => $query->func()->sum('hours_worked'),
			'total_unpaid' => $query->func()->sum($unPaidCase),
			'total_paid' => $query->func()->sum($paidCase)
		])->group(["job_id"]);
	}
	public function findPayTotals(Query $query, array $options)
	{
		$openInActCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['Jobs.is_open' => '1', 'Jobs.is_active' => 0]) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);
		$openActCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['Jobs.is_open' => 1, 'Jobs.is_active' => 1]) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);
		$closedCase = $query->newExpr()
			->addCase(
				[ $query->newExpr()->add(['Jobs.is_open' => 0]) ],
				[ new IdentifierExpression('hours_worked'), 0 ]
			);

		$query->contain(["Jobs"]);

		if ( array_key_exists("user", $options) ) {
			$query->where(["user_id" => $options["user"]]);
		}

		$query->where(["is_paid" => 0]);
		
		return $query->select([
			'total_unpaid' => $query->func()->sum("hours_worked"),
			'total_closed' => $query->func()->sum($closedCase),
			'total_active' => $query->func()->sum($openActCase),
			'total_open' => $query->func()->sum($openInActCase)
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
			->date('date_worked')
			->requirePresence('date_worked', 'create')
			->allowEmptyDate('date_worked', false);

		$validator
			->time('time_start')
			->allowEmptyTime('time_start', false);

		$validator
			->time('time_end')
			->allowEmptyTime('time_end', false);

		$validator
			->decimal('hours_worked')
			->allowEmpty('hours_worked');

		$validator
			->boolean('is_paid')
			->allowEmptyString('is_paid', false);

		$validator
			->scalar('notes')
			->maxLength('notes', 250)
			->allowEmptyString('notes', true);

		$validator
			->dateTime('created_at')
			->allowEmptyDateTime('created_at', false);

		$validator
			->dateTime('updated_at')
			->allowEmptyDateTime('updated_at', false);

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
