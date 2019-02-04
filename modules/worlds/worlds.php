<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 02.02.2019
 * Time: 20:16
 */

//require_once('../../db/DBConnection.php');
require_once('db/DBConnection.php');

class Worlds
{
	/**
	 * @var DBConnection
	 */
	private $dbConn;
	private $table;

	public function __construct(){

		$this->table = 'mod_world';
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
		}

		$this->dbConn->db->close();

		return $result;
	}

	/**
	 * Diese Funktion Holt die Liste für die Index Ansicht
	 *
	 * @return array|bool
	 */
	private function getIndex(){

		$sql = 'SELECT * FROM ' . $this->table;

		$tmpRes = $this->dbConn->db->query($sql);

		$result = $this->dbConn->mysqliToData($tmpRes);

		return $result;
	}


	private function loadData(Array &$data){

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ' . $data['id'];

		$tmpRes = $this->dbConn->db->query($sql);

		$result = $this->dbConn->mysqliToData($tmpRes);

		//parse to frontend model
		$result[0]['desc'] = $result[0]['description'];
		unset($result[0]['description']);

		return $result[0];
	}

	private function addData(Array &$data){

		$sql = 'INSERT INTO ' . $this->table .' (name, short, description, edition, author) VALUES ( ';
		$sql .= "'" . $data['name'] . "', ";
		$sql .= "'" . $data['short'] . "', ";
		$sql .= "'" . $data['desc'] . "', ";
		$sql .= "'" . $data['edition'] . "', ";
		$sql .= "'" . $data['author'] . "') ";

		$result['status'] = $this->dbConn->db->query($sql);

		return $result;
	}

	private function editData(Array &$data){

		$sql = 'UPDATE ' . $this->table . ' SET ';
		$sql .= "name = '"          . $data['name'] . "', ";
		$sql .= "short = '"         . $data['short'] . "', ";
		$sql .= "description = '"   . $data['desc'] . "', ";
		$sql .= "edition = '"       . $data['edition'] . "' ";
		$sql .= 'WHERE id = ' . $data['id'];

		$result['status'] = $this->dbConn->db->query($sql);

		return $result;
	}

	private function deleteData(Array &$data){

		$sql = 'DELETE FROM ' . $this->table . ' WHERE id = ' . $data['id'];

		$result['status'] = $this->dbConn->db->query($sql);

		return $result;
	}


	private function formatData($data){


	}
}