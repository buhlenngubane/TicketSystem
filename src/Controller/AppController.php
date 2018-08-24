<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Auth\BaseAuthenticate;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Auth;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
		
		//Loading the flash
        $this->loadComponent('Flash');
		
		//Confinguring Authentication
		$this->loadComponent('Auth', [
			'authorize' => 'Controller',
            'loginRedirect' => [
                'controller' => 'Initialize',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Initialize',
                'action' => 'index'
            ]
            
        ]);
    }
	
	//Adding interceptor between requests
	public function beforeFilter(Event $event) {
		//Allowing unregistered users to access actions
		$this->Auth->allow(['index','view', 'register', 'show']);
		
		//Saving authenticated user
		$this->set('loggedIn', $this->Auth->user());
	}
}
