<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reminders Model
 *
 * @method \App\Model\Entity\Reminder get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reminder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reminder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reminder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reminder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reminder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder findOrCreate($search, callable $callback = null, $options = [])
 */
class RemindersTable extends Table
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

        $this->setTable('reminders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('start_time')
            ->notEmptyDateTime('start_time');

        $validator
            ->nonNegativeInteger('type')
            ->notEmptyString('type');

        $validator
            ->nonNegativeInteger('period')
            ->notEmptyString('period');

        $validator
            ->dateTime('last_run')
            ->notEmptyDateTime('last_run');

        $validator
            ->scalar('toUsers')
            ->requirePresence('toUsers', 'create')
            ->notEmptyString('toUsers');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        return $validator;
    }
}
