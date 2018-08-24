<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
	//Adding multiple access protection
	protected $_accessible = [
		'*'=>true,
		'id'=>false
    ];
	
	//Setting password hash
	protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}