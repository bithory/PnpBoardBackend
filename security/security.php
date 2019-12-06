<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 05.04.2019
 * Time: 19:25
 */

require_once('./db/DBConnection.php');
require_once('./modelTemplates/modelTemplates.php');

class Security
{

	/**
	 * @var DBConnection
	 */
	private $dbConn;
	private $table;

	public function __construct(){

		$this->table = 'man_login_status';
	}

	public function dbAction(&$data){

		$this->dbConn = new DBConnection();

		$result = false;

		$result = $this->checkForLoginStatus($data);

		$this->dbConn->db->close();

		return $result;
	}

	public function checkResponsePermission(&$module, &$action, $token){

		$check = true;

		if($module == null)
			$check = false;

		if($action == null)
			$check = false;

		if($module != 'account' && strlen($token) < 5)  //token check for all modules != account
			$check = false;

		if($module == 'account' && $action != 'register'){
			if($action != 'login'){
				if(strlen($token) < 5)  //token check for module == account
					$check = false;
			}
		}

		return $check;
	}

	private function checkForLoginStatus(&$data){

		$query = "SELECT user_id FROM " . $this->table . " WHERE token = '" . $data['token'] . "'";

		$result = $this->dbConn->db->query($query);
		$result = $this->dbConn->mysqliToData($result);

		$temp['user_id'] =  $result [0]['user_id'];

		return $temp;
	}
}