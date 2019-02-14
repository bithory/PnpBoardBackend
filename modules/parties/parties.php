<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 04.02.2019
 * Time: 23:05
 */

require_once('./db/DBConnection.php');
require_once('./modelTemplates/modelTemplates.php');

class Parties
{

	/**
	 * @var DBConnection
	 */
	private $dbConn;
	/**
	 * @var ModelTemplates
	 */
	private $modTempl;

	private $mainTable      = 'mod_party';
	private $tabWorld       = 'mod_world';
	private $tabUser        = 'mod_user';
	private $tabRelUsrParty = 'rel_users_parties';

	public function __construct(){
	}

	public function dbAction(&$action, &$data){

		$this->dbConn   = new DBConnection();
		$this->modTempl = new ModelTemplates();

		$result = array();

		switch($action){

			case 'index':
				$result = $this->getIndex();
				break;
			case 'load':
				$result = $this->loadParty($data);
				break;
			case 'add':
				$result = $this->addParty($data);
				break;
			case 'edit':
				$result = $this->editParty($data);
				break;
			case 'delete':
				$result = $this->deleteParty($data);
				break;

			case 'usersList':
			case 'worldsList':
			case 'sheetsList':
				require_once ('./modules/parties/dataLists.php');
				$template   = new DataLists($this->dbConn);
				$result     = $template->dbAction($action, $data);
				break;
		}

		$this->dbConn->db->close();

		return $result;
	}

	private function getIndex(){

		$sql = 'SELECT a.id, a.name, b.name worldname FROM ' . $this->mainTable . ' a '
			. 'JOIN ' . $this->tabWorld . '  b ON a.world_id = b.id';

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		//Laden der Usernamen für die einzelnen Parties
		if(isset($result) && is_array($result)){

			$sql = 'SELECT b.username FROM ' . $this->tabRelUsrParty . ' a '
				. 'JOIN ' . $this->tabUser . ' b ON a.user_id = b.id '
				. 'WHERE a.party_id = ';

			foreach($result as $key => $val){

				$mysqli = $this->dbConn->db->query($sql . $val['id']);
				$tmp    = $this->dbConn->mysqliToData($mysqli);

				if(isset($tmp) && is_array($tmp)){

					foreach($tmp as $usrVal){

						$result[$key]['users'][]  = $this->modTempl->userTempl(array('username' => $usrVal['username']));
					}
				}

				//Setzen und anhängen der Worlddaten für die Party
				$result[$key]['world'] = $this->modTempl->worldTempl(array('name' => $val['worldname']));
				unset($result[$key]['worldname']);
			}
		}

		return $result;
	}

	private function  loadParty(&$data){

		$sql = 'SELECT * FROM ' . $this->mainTable . ' WHERE id = ' . $data['id'];

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);
		$this->dbConn->convertKey($result);


		if(isset($result) && is_array($result)){
			//##########################################################################################################
			//Laden der zugehörigen Nutzer
			$result = $result[0];

			$sql = 'SELECT b.id, b.username FROM ' . $this->tabRelUsrParty . ' a '
				. 'JOIN ' . $this->tabUser . ' b ON a.user_id = b.id '
				. 'WHERE a.party_id = ';

			$mysqli = $this->dbConn->db->query($sql . $data['id']);
			$tmp    = $this->dbConn->mysqliToData($mysqli);

			if(isset($tmp) && is_array($tmp)){

				foreach($tmp as $usrVal){

					$result['users'][] = $this->modTempl->userTempl(array('username' => $usrVal['username'], 'id' => $usrVal['id']));
				}
			}

			//##########################################################################################################
			//Laden der zugehörigen Welt
			$sql = 'SELECT id, name FROM ' . $this->tabWorld . ' WHERE id = ' . $result['worldId'];

			$mysqli = $this->dbConn->db->query($sql);
			$world  = $this->dbConn->mysqliToData($mysqli);
			$this->dbConn->convertKey($world);

			$result['world']    = $this->modTempl->worldTempl(array('id' => $world[0]['id'], 'name' => $world[0]['name']));
			$result['gm']       = $this->modTempl->userTempl(array('id' => $result['gm']));
			$result['sheet']    = $this->modTempl->sheetTempl(array('id' => $result['sheetId']));

			//um die Rückgabe an das Frontend Objekt anzupassen
			unset($result['worldId']);
			unset($result['sheetId']);
		}

		return $result;
	}

	private function addParty(&$data){

		$sql = 'INSERT INTO ' . $this->mainTable . ' (name, world_id, gm, sheet_id) VALUES('
			. "'"   . $data['name']         . "', "
					. $data['world']['id']  . ", "
					. $data['gm']['id']     . ", "
					. $data['sheet']['id']  .')';

		$result['status'] = $this->dbConn->db->query($sql);

		if($result['status']){

			$data['id'] = $this->dbConn->db->insert_id;

			$sql = $this->insertRelUsersParties($data);
			$result['status'] = $this->dbConn->db->query($sql);
		}

		return $result;
	}

	private function editParty(&$data){

		$sql = 'UPDATE '    . $this->mainTable      . ' SET '
			. "name = '"    . $data['name']         . "', "
			. 'world_id = ' . $data['world']['id']  . ', '
			. 'gm = '       . $data['gm']['id']     . ', '
			. 'sheet_id = ' . $data['sheet']['id']  .  ' '
			. 'WHERE id = ' . $data['id'];

		$result['status'] = $this->dbConn->db->query($sql);
		//##########################################################################################################
		//Löscht die bisher vorhandenen User, Party Relationen und schreibt diese neu
		if($result['status']){

			if(isset($data['users']) && is_array($data['users'])){

				$sql    = 'DELETE FROM ' . $this->tabRelUsrParty . ' WHERE party_id = ' . $data['id'];
				$check  = $this->dbConn->db->query($sql);

				if($check){

					$sql = $this->insertRelUsersParties($data);
				}

				$result['status'] = $this->dbConn->db->query($sql);
			}
		}

		return $result;
	}

	private function deleteParty(&$data){

		$sql = 'DELETE FROM ' . $this->mainTable . ' WHERE id = ' . $data['id'];

		$result['status'] = $this->dbConn->db->query($sql);

		return $result;
	}


	/**
	 * Konstruiert eine SQL INSERT Anweisung für die rel_users_parties Tabelle
	 *
	 * @param Array $data
	 * @return string
	 */
	private function insertRelUsersParties(&$data){


		$sql    = 'INSERT INTO ' . $this->tabRelUsrParty . ' (user_id, party_id) VALUES';

		foreach($data['users'] as $key => $val){

			if($key > 0)
				$sql .= ',';

			$sql .= '( '
				. $val['id'] . ', ' . $data['id']
				. ')';
		}

		return $sql;
	}
}