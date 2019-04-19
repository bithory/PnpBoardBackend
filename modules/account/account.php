<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 05.04.2019
 * Time: 19:21
 */

require_once('./db/DBConnection.php');
require_once('./modelTemplates/modelTemplates.php');

class Account
{

	/**
	 * @var DBConnection
	 */
	private $dbConn;
	private $table;

	public function __construct(){

		$this->table = 'mod_user';
	}

	public function dbAction(&$action, &$data){

		$this->dbConn = new DBConnection();

		$result = false;

		switch($action){
			case 'index':
				$result = $this->getIndex();
				break;
			case 'add':
				$result = $this->addData($data);
				break;
			case 'edit':
				$result = $this->editData($data);
				break;
			case 'load':
				$result = $this->loadData($data);
				break;
			case 'delete':
				$result = $this->deleteData($data);
				break;
			case 'resetEmail':
				$result = $this->resetEmail($data);
				break;
			case 'resetPw':
				$result = $this->resetPw($data);
				break;
			case 'login':
				$result = $this->login($data);
				break;
		}

		$this->dbConn->db->close();

		return $result;
	}

	private function getIndex(Array &$data){

	}

	private function addData(Array &$data){

	}

	private function editData(Array &$data){

	}

	private function loadData(Array &$data){
	}

	private function deleteData(Array &$data){

	}

	private function resetEmail(Array &$data){

	}

	private function resetPw(Array &$data){

	}

	private function login(Array &$data){

		if(!isset($data['token'])){

			$sql = 'SELECT username, id FROM ' . $this->table . ' WHERE '
				. "username = '"    . $data['username'] . "'AND "
				. "pw = '"          . $data['pw']       . "'";

			$mysqli = $this->dbConn->db->query($sql);
			$result = $this->dbConn->mysqliToData($mysqli);
			$result = $result[0];

			if(is_array($result) && $result != null){

				$hash   = substr($result['username'], 0, 1);    //first name letter
				$hash  .= substr($result['username'], -1, 1);   //last name letter
				$hash  .= '_';
				$hash  .= $result['id'];
				$hash  .= '_';
				$hash  .= time();

				$hash   = hash('sha256', $hash);

				$sql = 'INSERT INTO man_login_status (user_id, token, timestamp) VALUES('
					. ""    . $result['id'] .   ', '
					. "'"   . $hash         .   "', "
					. ""    . time()        .   ') ';

				unset($result);

				$result['status']   = $this->dbConn->db->query($sql);
				$result['token']     = "" . $hash;

				//because query return only false but not true
				$result['status']   = !$result['status'] ? $result['status'] : true;
			}
			else{

				$result['token']  = '';
				$result['status'] = false;
			}
		}
		else{

			$result['token']    = $data['token'];
			$result['status']   = true;
		}

		return $result;
	}
}