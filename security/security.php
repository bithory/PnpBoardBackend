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

	public function dbAction(&$action, &$data){

		$this->dbConn = new DBConnection();

		$result = false;

		switch($action){
			case 'setLogin':
				break;
		}

		$this->dbConn->db->close();

		return $result;
	}
}