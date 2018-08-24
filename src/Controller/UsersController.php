<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\Http\Response;
use Cake\Auth\BaseAuthenticate;
use Cake\View\Helper\FormHelper;
use Cake\Log\Log;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
	//Confinguring Authentication
	public $components = [
     'Auth' => [
         'authenticate' => ['Basic'=> [
            'fields' => ['username' => 'username', 'password' => 'password', 'role' => 'role'],
            'userModel' => 'Users'
        ],
		]
     ]
	];
	
	//Inheriting parent filter function
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
	
	}

	//Setting authorization based on role
	public function isAuthorized($user)
	{
		// All registered users can add articles
		// Prior to 3.4.0 $this->request->param('action') was used.
		if ($this->request->getParam('action') === 'logout') {
			
			//if (isset($user['role']) && ($user['role'] === 'sales' || $user['role'] === 'accounts')) 
				//return true;
			//else
				return true;
		}

		// The owner of an article can edit and delete it
		// Prior to 3.4.0 $this->request->param('action') was used.
		
		return true;
		//return parent::isAuthorized($user);
	}
    

    /**
     * Register method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 
    public function register()
    {
		$user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
				$user = $this->Auth->identify();
				$this->Auth->setUser($user);
                return $this->redirect(['controller' => 'Initialize', 'action' => 'index']);
            }
			else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
        }
        $this->set('user', $user);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null Redirects on successful check, displays error otherwise.
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
				if ($user['role'] == $this->request->data['role']) {
					Log::debug('Got here');
					$this->Auth->setUser($user);
					//$token = $this->request->getParam('_csrfToken');
					$this->Flash->success(__('Welcome '.$user['username'].'.'));
					return $this->redirect($this->Auth->redirectUrl());
				} else {
					return $this->Flash->error(__('Invalid role, try again'));
				}
            }

            $this->Flash->error(__('Invalid email or password, try again'));
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null Redirects on successful delete.
     */
    public function logout()
    {
        $session = $this->request->session();
        $session->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
