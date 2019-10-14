<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 10.03.2019
 * Time: 15:07
 */

class Tags
{
	/**
	 * @var DBConnection
	 */
	private $dbConn;

	private $table;

	private $dev;

	public function __construct(){

		$this->table = 'mod_tag';
	}

	public function dbAction(&$action, &$data, &$dev){

		$this->dbConn   = new DBConnection();
		$this->dev      = $dev;

		$result = false;

		switch($action){
			case 'index':
				$result = $this->getIndex($data);
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
	private function getIndex(Array &$data){

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE party_id = ' . $data['id'] . ' ORDER BY id DESC';

		$tmpRes = $this->dbConn->db->query($sql);

		$result = $this->dbConn->mysqliToData($tmpRes);

		return $result;
	}


	private function loadData(Array &$data){

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ' . $data['id'];

		$tmpRes = $this->dbConn->db->query($sql);

		$result = $this->dbConn->mysqliToData($tmpRes);
		$this->dbConn->convertKey($result);

		return $result[0];
	}

	private function addData(Array &$data){

		$sql = 'INSERT INTO ' . $this->table .' (name, party_id) VALUES ( ';
		$sql .= "'" . $data['name']     . "', ";
		$sql .= "" . $data['partyId']   . ") ";

		$result['status'] = $this->dbConn->db->query($sql);

		$result  =  0;
		return $result;
	}

	private function editData(Array &$data){

		$sql = 'UPDATE ' . $this->table . ' SET ';
		$sql .= "name = '"          . $data['name']     . "', ";
		$sql .= "party_id = "       . $data['partyId']   . " ";
		$sql .= 'WHERE id = '       . $data['id'];

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