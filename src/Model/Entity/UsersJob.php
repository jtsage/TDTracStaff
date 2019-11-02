<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersJob Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $job_id
 * @property string $role_id
 * @property int $is_available
 * @property int $is_scheduled
 * @property string|null $note
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Job $job
 * @property \App\Model\Entity\Role $role
 */
class UsersJob extends Entity
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
        'user_id' => true,
        'job_id' => true,
        'role_id' => true,
        'is_available' => true,
        'is_scheduled' => true,
        'note' => true,
        'user' => true,
        'job' => true,
        'role' => true
    ];
}
