<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Budget Entity
 *
 * @property string $id
 * @property string $vendor
 * @property string $category
 * @property string|null $detail
 * @property \Cake\I18n\FrozenDate $date
 * @property float $amount
 * @property string $user_id
 * @property string $job_id
 * @property \Cake\I18n\FrozenTime $created_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Job $job
 */
class Budget extends Entity
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
        'vendor' => true,
        'category' => true,
        'detail' => true,
        'date' => true,
        'amount' => true,
        'user_id' => true,
        'job_id' => true,
        'created_at' => true,
        'user' => true,
        'job' => true
    ];
}
