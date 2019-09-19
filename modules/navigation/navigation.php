<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 04.02.2019
 * Time: 14:19
 */

require_once('db/DBConnection.php');

class Navigation
{

	/**
	 * @var DBConnection
	 */
	private $dbConn;
	private $table1;

	public function __construct(){


	}

	public function dbAction(&$action, &$data){

		$this->dbConn = new DBConnection();

		$result = $this->getNavigation($data);

		$this->dbConn->db->close();

		return $result;
	}

	private function getNavigation(&$data){

		if($data['user_id']){

			$sql = 'SELECT c.id world_id, c.name, c.short FROM rel_users_parties a '
				. 'JOIN mod_party b ON a.party_id = b.id '
				. 'JOIN mod_world c ON b.world_id = c.id '
				. 'Where a.user_id = ' . $data['user_id'] . ' GROUP BY world_id';

			$mysqli = $this->dbConn->db->query($sql);

			$result = $this->dbConn->mysqliToData($mysqli);
			$this->dbConn->convertKey($result);


			if(isset($result) && $result){

				$tmp = array();

				foreach($result as $key => $val){

					$sql = 'SELECT id party_id, name party_name FROM mod_party a JOIN rel_users_parties b ON a.id = b.party_id '
						. 'WHERE a.world_id = ' . $val['worldId'] . ' AND b.user_id = ' . $data['user_id'];

					$mysqli = $this->dbConn->db->query($sql);
					$tmp    = $this->dbConn->mysqliToData($mysqli);
					$this->dbConn->convertKey($tmp);

					$result[$key]['party'] = $tmp;
				}
			}
		}

		return $result;
	}
}