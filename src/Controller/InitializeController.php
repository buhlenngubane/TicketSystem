<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Error\Debugger;
use Cake\Log\Log;
use Cake\Core\Exception\Exception;
use Cake\Database\Exception\MissingConnectionException;

/**
 * Initialize Controller
 *
 *
 * @method \App\Model\Entity\Initialize[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InitializeController extends AppController
{

    /**
     * Index method 
	 *
     * creating and install the database and credentials needed for the project to run
     * pre-population of data for the users.
     */
	
    public function index()
    {
		$connected = false;
		if ($this->request->is('post')) :
			try{
				if($this->request->data['Username'] != '') {
				$dsn = "mysql://root@localhost/test";
				ConnectionManager::config('defaultConnection', ['url' => $dsn]);
				$connection = ConnectionManager::get('defaultConnection');
				
				$connection->query("CREATE USER ".$this->request->data['Username'].
				"@'localhost' IDENTIFIED BY '".$this->request->data['Password']."';",$connection);
				
				$connection->query("CREATE DATABASE IF NOT EXISTS my_app");
				
				$connection->query("GRANT ALL ON my_app.* TO ".
				$this->request->data['Username']."@'localhost'");
				
				$dsn = "mysql://".$this->request->data['Username'].":".
				$this->request->data['Password']."@localhost/my_app";
				
				ConnectionManager::config('my_connection', ['url' => $dsn]);
				$connection = ConnectionManager::get('my_connection');
				$connected = $connection->connect();
				
				$sql = "CREATE TABLE IF NOT EXISTS users (
						id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
						username VARCHAR(50) NOT NULL UNIQUE,
						password VARCHAR(255) NOT NULL,
						role VARCHAR(30) NOT NULL
					)";
				$connection->query($sql);
				$sql = "CREATE TABLE IF NOT EXISTS Ticket (
						id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
						name VARCHAR(50) NOT NULL,
						surname VARCHAR(50) NOT NULL,
						email VARCHAR(50) NOT NULL UNIQUE,
						phoneNo VARCHAR(50) NOT NULL,
						ticket VARCHAR(150) NOT NULL,
						status VARCHAR(30) NOT NULL
					)";
				$connection->query($sql);
				$connection->query("INSERT IGNORE INTO users (username, password, role)
						VALUES ('John@gmail.com', '".(new DefaultPasswordHasher)->hash('123')."', 'sales')");
				$connection->query("INSERT IGNORE INTO users (username, password, role)
						VALUES ('Hailey@gmail.com', '".(new DefaultPasswordHasher)->hash('1234')."', 'accounts')");
				$connection->query("INSERT IGNORE INTO users (username, password, role)
						VALUES ('Mustapha@gmail.com', '".(new DefaultPasswordHasher)->hash('12345')."', 'it')");
				} else {
					$this->Flash->error(__('Username is required.'));
				}
			}
			
			catch (\PDOException $connectionError) {
				$this->Flash->error(__('Error occured, '.$connectionError->getMessage()));
			}
			catch(MissingConnectionException $connectionError)
			{
				$this->Flash->error(__('Error occured, Database/User not created successfully. Please try again.'));
			}
		else :
			try {
				//Default connection used
				$dsn = "mysql://root@localhost/my_app4";
				ConnectionManager::config('my_connection', ['url' => $dsn]);
				$connection = ConnectionManager::get('my_connection');
				$connected = $connection->connect();
				Log::debug('Got here');

			} catch (Exception $connectionError) {
				$connected = false;
				$errorMsg = $connectionError->getMessage();
				if (method_exists($connectionError, 'getAttributes')) :
					$attributes = $connectionError->getAttributes();
					$this->Flash->error(__('Please, login in to create database and initialize with default data.'));
				endif;
			}
		endif;
		
        
        $this->set(compact('connected'));
    }
	
	
}
