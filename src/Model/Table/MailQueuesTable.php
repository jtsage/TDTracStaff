<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MailQueues Model
 *
 * @method \App\Model\Entity\MailQueue get($primaryKey, $options = [])
 * @method \App\Model\Entity\MailQueue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MailQueue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MailQueue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MailQueue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MailQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MailQueue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MailQueue findOrCreate($search, callable $callback = null, $options = [])
 */
class MailQueuesTable extends Table
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

        $this->setTable('mail_queues');
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('template')
            ->maxLength('template', 50)
            ->allowEmptyString('template', false);

        $validator
            ->scalar('toUser')
            ->maxLength('toUser', 250)
            ->requirePresence('toUser', 'create')
            ->allowEmptyString('toUser', false);

        $validator
            ->scalar('subject')
            ->maxLength('subject', 250)
            ->requirePresence('subject', 'create')
            ->allowEmptyString('subject', false);

        $validator
            ->scalar('viewvars')
            ->allowEmptyString('viewvars');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->allowEmptyString('body', false);

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at', false);

        return $validator;
    }
}
