<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppConfigs Model
 *
 * @method \App\Model\Entity\AppConfig get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppConfig newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppConfig[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppConfig|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppConfig saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppConfig patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppConfig[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppConfig findOrCreate($search, callable $callback = null, $options = [])
 */
class AppConfigsTable extends Table
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

        $this->setTable('app_configs');
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
            ->scalar('key_name')
            ->maxLength('key_name', 50)
            ->requirePresence('key_name', 'create')
            ->allowEmptyString('key_name', false);

        $validator
            ->scalar('value_short')
            ->maxLength('value_short', 250)
            ->allowEmptyString('value_short');

        $validator
            ->scalar('value_long')
            ->allowEmptyString('value_long');

        return $validator;
    }
}
