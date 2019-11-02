<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payroll Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenDate $date_worked
 * @property \Cake\I18n\FrozenTime $time_start
 * @property \Cake\I18n\FrozenTime $time_end
 * @property int|null $hours_worked
 * @property bool $is_paid
 * @property string $user_id
 * @property string $job_id
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Job $job
 */
class Payroll extends Entity
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
        'date_worked' => true,
        'time_start' => true,
        'time_end' => true,
        'hours_worked' => true,
        'is_paid' => true,
        'user_id' => true,
        'job_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'user' => true,
        'job' => true
    ];
}
