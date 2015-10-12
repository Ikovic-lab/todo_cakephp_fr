<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

use Cake\Collection\Collection;
	
/**
 * Bookmark Entity.
 */
class Todo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'text' => true,
        'status' => true,
    ];
	
	
}
