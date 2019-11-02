<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            ->integer('hours_worked')
            ->allowEmptyString('hours_worked');

        $validator
            ->boolean('is_paid')
            ->allowEmptyString('is_paid', false);

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
