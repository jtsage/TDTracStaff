<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MailQueue Entity
 *
 * @property string $id
 * @property string $template
 * @property string $to
 * @property string $subject
 * @property string|null $viewvars
 * @property string $body
 * @property \Cake\I18n\FrozenTime $created_at
 */
class MailQueue extends Entity
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
        'template' => true,
        'toUser' => true,
        'subject' => true,
        'viewvars' => true,
        'body' => true,
        'created_at' => true
    ];
}
