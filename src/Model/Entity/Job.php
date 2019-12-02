<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity
 *
 * @property string $id
 * @property string $name
 * @property string|null $detail
 * @property string|null $location
 * @property string|null $category
 * @property \Cake\I18n\FrozenDate $date_start
 * @property \Cake\I18n\FrozenDate $date_end
 * @property string $time_string
 * @property bool $is_active
 * @property bool $is_open
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 * @property \App\Model\Entity\Payroll[] $payrolls
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\User[] $users
 */
class Job extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'detail' => true,
        'location' => true,
        'category' => true,
        'date_start' => true,
        'date_end' => true,
        'time_string' => true,
        'notes' => true,
        'is_active' => true,
        'is_open' => true,
        'has_payroll' => true,
        'has_budget' => true,
        'has_budget_total' => true,
        'created_at' => true,
        'updated_at' => true,
        'due_payroll_submitted' => true,
        'due_payroll_paid' => true,
        'parent_id' => true,
        'payrolls' => true,
        'roles' => true,
        'users' => true
    ];
}
