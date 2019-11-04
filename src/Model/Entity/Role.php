<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property string $id
 * @property string $title
 * @property string $detail
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 * @property \App\Model\Entity\UsersJob[] $users_jobs
 * @property \App\Model\Entity\Job[] $jobs
 * @property \App\Model\Entity\User[] $users
 */
class Role extends Entity
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
        'title' => true,
        'detail' => true,
        'created_at' => true,
        'updated_at' => true,
        'users_jobs' => true,
        'jobs' => true,
        'users' => true,
        'sort_order' => true
    ];
}
