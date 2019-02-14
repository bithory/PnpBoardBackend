<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 07.02.2019
 * Time: 23:50
 */

require_once('./modelTemplates/modelTemplates.php');

class DataLists
{

	/**
	 * @var DBConnection
	 */
	private $dbConn;
	/**
	 * @var ModelTemplates
	 */
	private $modTempl;

	private $tabUser    = 'mod_user';
	private $tabWorld   = 'mod_world';
	private $tabSheet   = 'mod_sheet';

	private $tabRelPartyUsr = 'rel_users_parties';

	public function __construct(&$dbConn){

		$this->dbConn   = $dbConn;
		$this->modTempl = new ModelTemplates();
	}


	public function dbAction(&$action, &$data){

		$result = array();

		switch($action){

			case 'usersList':
				$result = $this->getUsersList();
				break;
			case 'worldsList':
				$result = $this->getWorldsList($data);
				break;
			case 'sheetsList':
				$result = $this->getSheetsList($data);
				break;
		}

		return $result;
	}

	private function getUsersList(){

		$sql = "SELECT id, username FROM " . $this->tabUser;

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		//Parsen zu einem vollwertigen User Model
		if(isset($result) && is_array($result)){

//			var_dump($result);

			foreach($result as $key => $val){

				$paramArr = array(
					'username'  => $val['username'],
					'id'        => $val['id'],
				);

				$result[$key] = $this->modTempl->userTempl($paramArr);
			}
		}

		return $result;
	}


	private function getWorldsList(&$data){

		$sql = "SELECT id, name FROM " . $this->tabWorld;

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		if(isset($result) && is_array($result)){

			$tmp    = $result;
			$result = array();

			foreach($tmp as $val){

				$result[] = $this->modTempl->worldTempl(array('id' => $val['id'], 'name' => $val['name']));
			}
		}

		return $result;
	}


	private function getSheetsList(&$data){

		$sql = '';

		if(isset($data) && $data['id'] > 0)
			$sql = "SELECT id, name FROM " . $this->tabSheet . " WHERE world_id = " . $data['id'];
		else
			$sql = "SELECT id, name FROM " . $this->tabSheet;

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		return $result;
	}
}