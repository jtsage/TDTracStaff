<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppConfig Entity
 *
 * @property string $id
 * @property string $key_name
 * @property string|null $value_short
 * @property string|null $value_long
 */
class AppConfig extends Entity
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
        'key_name' => true,
        'value_short' => true,
        'value_long' => true
    ];
}
