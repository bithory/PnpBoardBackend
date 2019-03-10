<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 27.02.2019
 * Time: 00:43
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
	private $tabParty   = 'mod_party';
	private $tabTags    = 'mod_tag';

	private $tabRelPartyUsr = 'rel_users_parties';

	public function __construct(&$dbConn){

		$this->dbConn   = $dbConn;
		$this->modTempl = new ModelTemplates();
	}


	public function dbAction(&$action, &$data){

		$result = array();

		switch($action){

			case 'usersList':
				$result = $this->getUsersList($data);
				break;
			case 'tagsList':
				$result = $this->getTagsList($data);
				break;
		}

		return $result;
	}


	private function getUsersList(&$data){

		$sql = 'SELECT a.username, a.id FROM ' . $this->tabUser . ' a '
			. 'JOIN ' . $this->tabRelPartyUsr . ' b ON a.id = b.user_id '
			. 'JOIN ' . $this->tabParty . ' c ON b.party_id = c.id '
			. 'WHERE c.id = ' . $data['partyId'];

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		if(isset($result) && is_array($result)){

			foreach($result as $key => $val){

				$result[$key] = $this->modTempl->userTempl(array('id' => $val['id'], 'username' => $val['username']));
			}
		}

		return $result;
	}

	private function getTagsList(&$data){

		$sql = 'SELECT * FROM ' . $this->tabTags . ' WHERE party_id = ' . $data['partyId'];

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);
		$this->dbConn->convertKey($result);

		if(isset($result) && is_array($result)){

			foreach($result as $key => $val){

				$result[$key] = $this->modTempl->tagTempl($val);
			}
		}

		return $result;
	}
}