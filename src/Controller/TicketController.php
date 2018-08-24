<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Ticket Controller
 *
 *
 * @method \App\Model\Entity\Ticket[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TicketController extends AppController
{
	//Inheriting parent filter
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
	}
	
    //Adding authorization by usertype
	public function isAuthorized($user)
	{
		// Only users with role sales/accounts can add tickets
		if ($this->request->getParam('action') === 'add') {
			if (isset($user['role']) && ($user['role'] === 'sales' || $user['role'] === 'accounts')) 
				return true;
			else
				return false;
		}
		
		//Only users with role it can edit tickets
		if ($this->request->getParam('action') === 'edit') {
			if (isset($user['role']) && $user['role'] === 'it') 
				return true;
			else
				return false;
		}
		return true;
	}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, returns error otherwise.
     */
    public function add()
    {
        $ticket = $this->Ticket->newEntity();
		$success = false;
        if ($this->request->is('post')) {
            $ticket = $this->Ticket->patchEntity($ticket, $this->request->getData());
            if ($this->Ticket->save($ticket)) {
				try{
					//Configuring email transport details
					Email::configTransport('gmail', [
						'host' => 'smtp.gmail.com',
						'port' => 587,
						'username' => 'validtest.r.me@gmail.com',
						'password' => 'ReversideBooking',
						'className' => 'Smtp',
						'tls' => true
					]);
					
					//Creating and sending email
					$email = new Email();
					$email->setTransport('gmail');
					$email->emailFormat('html');
					$email->subject('Message');
					$email->to($ticket->email);
					$email->from(['validtest.r.me@gmail.com'=>'Ticket System']);
					$email->send('<div><a href="http://localhost:8765/Ticket/show/"'.$ticket->id.'">Check Ticket Status</a></div>');
					
					$this->Flash->success(__('The ticket has been sent to your email. Ticket id = '.$ticket->id));
					return $this->redirect(['controller' => 'Initialize', 'action' => 'index']);
				} catch (Exception $error) {
					$this->Flash->error(__('An error has occured. Please, try again.'));
				}
            }
            $this->Flash->error(__('The ticket could not be saved. Please, try again.'));
        }
		
		//setting ticket for view retrieval
        $this->set('ticket',$ticket);
	}

    /**
     * Edit method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Http\Response|null Redirects on successful edit, returns error otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {		
		//Find ticket number
        if ($this->request->is(['patch', 'post', 'put'])) {
			try{
				$id = $this->request->data['id'];
				$ticket = $this->Ticket->get($id);
				$ticket->status = $this->request->data['status'];
				if ($this->Ticket->save($ticket)) {
					$this->Flash->success(__('The ticket has been saved. Ticket id = '.$ticket->id));
					return $this->redirect(['controller' => 'Initialize', 'action' => 'index']);
				}
			
				$this->Flash->error(__('The ticket could not be saved. Please, try again.'));
			} catch (RecordNotFoundException $err) {
				return $this->Flash->error(__('The ticket could not be found. Please, try again.'));
			}
			
        }
    }
	
	/**
	 * Show method
	 *
	 * To display ticket by id
	 */
	
	public function show($id = null) {
		//$id = $this->request->query('id');
		try{
			$ticket = $this->Ticket->get($id);
		}
		catch (Exception $error)
		{
			$this->Flash->error(__('Error occured, '. $error->getMessage().'. Ticket id = '.$id));
			return $this->redirect(['controller' => 'Initialize', 'action' => 'index']);
		}
		
		//setting ticket for view retrieval
        $this->set('ticket',$ticket);
	}
}
