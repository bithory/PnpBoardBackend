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
	private $logStatTable;

	private $modTempl;

	private $dev;

	public function __construct(){

		$this->table        = 'mod_user';
		$this->logStatTable = 'man_login_status';

		$this->modTempl = new ModelTemplates();
	}

	public function dbAction(&$action, &$data, &$dev){

		$this->dbConn = new DBConnection();

		$this->dev = $dev;

		$result = false;

		switch($action){
			case 'index':
				$result = $this->getIndex();
				break;
			case 'register':
				$result = $this->register($data);
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
			case 'logout':
				$result = $this->logout($data);
				break;
		}

		$this->dbConn->db->close();

		return $result;
	}

	private function getIndex(Array &$data){

	}

	private function register(Array &$data){

		$query = "INSERT INTO " . $this->table . "(username, pw, email, sec_question, sec_answer) VALUES ("
			. "'" . $data['username']   . "', "
			. "'" . $data['pw']         . "', "
			. "'" . $data['email']      . "', "
			. "'" . $data['question']   . "', "
			. "'" . $data['answer']     . "')";

		$mysqli = $this->dbConn->db->query($query);
		$result = null;

		if(!$mysqli)
			$result = $this->modTempl->statusTempl(array('status' => false, 'msg' => 'username'));
		else
			$result = $this->modTempl->statusTempl(array('status' => true, 'msg' => ''));

		return $result;
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

	/**
	 * Checks for User and set it to the man_login_status table.
	 * if user still is in table it will return the table data
	 * if user not exits in man_login_status table it will insert user into the table
	 *
	 * @param array $data
	 * @return array|mixed
	 */
	private function login(Array &$data){

		$time = time();

		if(!isset($data['token'])){

			$sql = 'SELECT username, id FROM ' . $this->table . ' WHERE '
				. "username = '"    . $data['username'] . "'AND "
				. "pw = '"          . $data['pw']       . "'";

			$mysqli = $this->dbConn->db->query($sql);
			$result = $this->dbConn->mysqliToData($mysqli);
			$result = $result[0];
			//generate token and insert into login table
			if(is_array($result) && $result != null){

				//example for user: max, id = 1, time 30.04.2019 - 12:59:16
				//not crypted token: mx_1_1556621956
				$hash   = substr($result['username'], 0, 1);    //first name letter
				$hash  .= substr($result['username'], -1, 1);   //last name letter
				$hash  .= '_';
				$hash  .= $result['id'];
				$hash  .= '_';
				$hash  .= $time; //in unixtime

				$hash   = hash('sha256', $hash);

				$userData = $result;

				$sql = 'SELECT token, timestamp FROM ' . $this->logStatTable . ' WHERE user_id = ' . $result['id'];

				$mysqli = $this->dbConn->db->query($sql);
				$result = $this->dbConn->mysqliToData($mysqli);

				if(is_array($result) && $result != null){ //update the frontend data

					if($this->dev)
						echo 'update login  <br>';

					$result = $result[0];

					$result['status'] = true;

					$result = $this->modTempl->loginTempl($result);
				}
				else{   //insert into login table

					if($this->dev)
						echo 'insert login  <br>';

					$result = $this->insertLogin($userData, $hash, $time);
				}
			}
			else{


				$result['token']  = '';
				$result['status'] = false;
				$result['timestamp']= $time;
			}
		}
		else{

			$result['token']    = $data['token'];
			$result['status']   = true;
			$result['timestamp']= $time;

			$result = $this->modTempl->loginTempl($result);
		}

		return $result;
	}

	private function insertLogin($data, $hash, $time){

		$sql = 'INSERT INTO man_login_status (user_id, token, timestamp) VALUES('
			. ""    . $data['id'] .   ', '
			. "'"   . $hash         .   "', "
			. ""    . $time         .   ') ';

		if($this->dev)
			echo 'INSERT_LOGIN QUERY: ' . $sql . '  <br>  ';

		$result = array();

		$result['token']    = "" . $hash;
		$result['status']   = $this->dbConn->db->query($sql);
		$result['timestamp']= $time;

		//because query return only false but not true
		$result['status']   = !$result['status'] ? $result['status'] : true;

		$result = $this->modTempl->loginTempl($result);

		return $result;
	}

	private function logout(Array &$data){

		$sql = 'DELETE FROM ' . $this->logStatTable . " WHERE token = '" . $data['token'] . "'";

		$result['status']   = $this->dbConn->db->query($sql);
		$result             = $this->modTempl->statusTempl($result);

		if($this->dev){

			echo $sql . '<br><lr/><br>';
			var_dump($result);
		}

		return $result;
	}
}