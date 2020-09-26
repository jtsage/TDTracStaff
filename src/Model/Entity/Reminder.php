<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reminder Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime $start_time
 * @property int $type
 * @property int $period
 * @property \Cake\I18n\FrozenTime $last_run
 * @property string $toUsers
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created_at
 */
class Reminder extends Entity
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
        'start_time' => true,
        'type' => true,
        'period' => true,
        'last_run' => true,
        'toUsers' => true,
        'description' => true,
        'created_at' => true,
    ];
}
