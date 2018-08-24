<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TicketTable extends Table
{
	//Validating the form view
    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('name', 'A name is required')
            ->notEmpty('surname', 'A password is required')
            ->notEmpty('email', 'A email is required')
			->notEmpty('phoneNo', 'A phone number is required')
			->notEmpty('ticket', 'Ticket detail is required')
			->notEmpty('status', 'A status is required')
            ->add('status', 'inList', [
                'rule' => ['inList', ['newly logged', 'in progress', 'resolved']],
                'message' => 'Please enter a valid status'
            ]);
    }
	

}