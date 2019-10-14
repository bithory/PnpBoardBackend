<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 27.02.2019
 * Time: 00:42
 */

require_once ('./modules/modulInterface.php');
require_once ('./modelTemplates/modelTemplates.php');

class Notes
{

	private $mainTable  = 'mod_note';
	private $table1     = 'mod_user';
	private $table2     = 'mod_tag';
	private $tabRel     = 'rel_notes_users_tags';


	/**
	 * @var DBConnection
	 */
	private $dbConn;

	/**
	 * @var ModelTemplates
	 */
	private $modTempl;

	private $dev;

	public function __construct()
	{

		$this->dbConn   = new DBConnection();
		$this->modTempl = new ModelTemplates();
	}

	public function dbAction(&$action, &$data, &$dev){

		$result     = array();
		$this->dev  = $dev;

		switch($action){

			case 'index':
				$result = $this->getIndex($data);
				break;
			case 'load':
				$result = $this->load($data);
				break;
			case 'add':
				$result = $this->add($data);
				break;
			case 'edit':
				$result = $this->edit($data);
				break;
			case 'delete':
				$result = $this->delete($data);
				break;
			case 'search':
				$result = $this->search($data);
				break;
			default:    //loading of the templaes
				require_once ('./modules/notes/dataLists.php');
				$template   = new DataLists($this->dbConn);
				$result     = $template->dbAction($action, $data);
				break;
		}

		$this->dbConn->db->close();

		return $result;
	}

	protected function getIndex(&$data)
	{

		$sql = 'SELECT DISTINCT a.id, a.name, a.party_id, a.note_date, a.user_id  FROM ' . $this->mainTable . ' a JOIN ' . $this->tabRel . ' b ON a.id = b.note_id '
			. 'WHERE party_id = '   . $data['partyId']  . ' '
			. 'AND (a.user_id = '   . $data['user_id']   . ' '
			. 'OR b.user_id = '     . $data['user_id']   . ') '
			. 'ORDER BY id DESC';

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		if(isset($result) && is_array($result)){

			$this->dbConn->convertKey($result);
			$this->setAuthor($result, $data);
			$this->getSubModels($result, 'tags');
		}

		return $result;
	}

	protected function load(&$data)
	{

		$sql = 'SELECT * FROM ' . $this->mainTable . ' WHERE id = ' . $data['id'];

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);
		$this->dbConn->convertKey($result);

		$result[0] = $this->modTempl->noteTempl($result[0]);

		$this->getSubModels($result, 'read');
		$this->getSubModels($result, 'tags');

		return $result[0];
	}

	protected function add(&$data)
	{

		$sql = "INSERT INTO " . $this->mainTable . "(name, note_text, user_id, party_id, note_date) "
			. "VALUES ('"   . $data['name']             . "', "
			. "'"           . $data['text']             . "', "
			. " "           . $data['userId']           . ", "
			. " "           . $data['partyId']          . ", "
			. " "           . time()                    . ")";

		$result = $this->dbConn->db->query($sql);

		if($result){

			$data['id'] = mysqli_insert_id($this->dbConn->db);

			$sqlBasic = "INSERT INTO " . $this->tabRel . " (note_id, user_id, tag_id) VALUES ";

			//add the users: which are allowed to read ###############################
			$sql = $sqlBasic;

			foreach($data['read'] as $key => $val){

				if($key > 0)
					$sql .= ', ';

				$sql .= '(' . $data['id'] . ', ' . $val['id'] . ', 0)';
			}

			$read = $this->dbConn->db->query($sql);

			//add the related tags ###############################
			$sql = $sqlBasic;

			foreach($data['tags'] as $key => $val){

				if($key > 0)
					$sql .= ', ';

				$sql .= '(' . $data['id'] . ', 0, ' . $val['id'] . ')';
			}

			$tags = $this->dbConn->db->query($sql);

			if(!$read || !$tags)
				$result = false;
		}

		return $result;
	}

	protected function edit(&$data)
	{

		$sql = "UPDATE " . $this->mainTable . " SET "
			. "name = '"        . $data['name']             . "', "
			. "note_text = '"   . $data['text']             . "', "
			. "user_id = "      . $data['userId']           . ", "
			. "party_id = "     . $data['partyId']          . ", "
			. "note_date = "    . strtotime($data['date'])  . " "
			. "WHERE id = "     . $data['id'];

		$result = $this->dbConn->db->query($sql);

		if($result){

			$sql = "DELETE FROM " . $this->tabRel . " WHERE note_id = " . $data['id'];

			$result = $this->dbConn->db->query($sql);

			if($result){

				$sqlBasic = "INSERT INTO " . $this->tabRel . " (note_id, user_id, tag_id) "
					. "VALUES ";

				//Update der Nutzer
				$sql = $sqlBasic;

				foreach($data['read'] as $key => $val){

					if($key > 0)
						$sql .= ",";

					$sql .= "(" . $data['id'] . ", " . $val['id'] . ", 0)";
				}

				$users = $this->dbConn->db->query($sql);

				//Update tags
				$sql = $sqlBasic;

				foreach($data['tags'] as $key => $val){

					if($key > 0)
						$sql .= ",";

					$sql .= "(" . $data['id'] . ", 0, " . $val['id'] . ")";
				}

				$tags = $this->dbConn->db->query($sql);

				if(!$users || !$tags)
					$result = false;
			}
		}

		return $result;
	}

	protected function delete(&$data)
	{

		$sql = "DELETE FROM " . $this->mainTable . " WHERE id = " . $data['id'];

		$result = $this->dbConn->db->query($sql);

		//Löschen der Zuordnung zu Tags und User
		if($result){

			$sql = "DELETE FROM " . $this->tabRel . " WHERE note_id = " . $data['id'];

			$result = $this->dbConn->db->query($sql);
		}

		return $result;
	}

	/**
	 * holt die Submodel Daten
	 *
	 * @param array $arr
	 * @param string $submodell = read, tags
	 */
	private function getSubModels(Array &$arr, $submodell = 'tags'){

		$options = array();

		if($submodell == 'read'){

			$options['table']  = $this->table1;
			$options['col']    = 'user_id';
			$options['select'] = 'id, username';
		}
		else{

			$options['table']   = $this->table2;
			$options['col']     = 'tag_id';
			$options['select']  = 'id, name';
		}

		$result = null;

		$basicSql = 'SELECT ' . ($options['select'] ? $options['select'] : '*') . ' FROM ' . $options['table'] . ' a '
			. 'JOIN ' . $this->tabRel . ' b ON a.id = b.' . $options['col'] . ' '
			. 'WHERE ';

		if(isset($arr) && is_array($arr)){


			foreach($arr as $key => $val){

				$sql = $basicSql . 'b.note_id = ' . $val['id'] . ' ';

				$mysqli = $this->dbConn->db->query($sql);
				$result = $this->dbConn->mysqliToData($mysqli);

				if(isset($result) && is_array($result)){

					foreach($result as $resKey => $resVal){

						if($submodell == 'read')
							$result[$resKey] = $this->modTempl->userTempl($resVal);
						else
							$result[$resKey] = $this->modTempl->tagTempl($resVal);
					}

					$arr[$key][$submodell] = $result;
				}
			}
		}
	}

	private function search(&$data){

		$elem = explode(', ', $data['search']);

		$sql = 'SELECT DISTINCT a.id, a.name, a.note_text, a.user_id, a.party_id, a.note_date FROM ' . $this->mainTable
			. ' a JOIN ' . $this->tabRel . ' b ON a.id = b.note_id '
			. 'JOIN ' . $this->table2 . ' c ON b.tag_id = c.id WHERE '
			. '(a.user_id = ' . $data['user_id'] . ' OR b.user_id = ' . $data['user_id'] . ') AND (';


		if(is_array($elem) && $elem != null){

			$isFirst = true;

			foreach($elem as $val){

				if($isFirst){

					$sql .= "a.name LIKE '%" . $val . "%' OR c.name LIKE '%" . $val . "%' ";
					$isFirst = false;
				}
				else{

					$sql .= "OR a.name LIKE '%" . $val . "%' OR c.name LIKE '%" . $val . "%' ";
				}

			}
		}

		$sql .= ') '
			. 'ORDER BY a.id DESC';

		$mysqli = $this->dbConn->db->query($sql);
		$result = $this->dbConn->mysqliToData($mysqli);

		$this->dbConn->convertKey($result);

		$this->setAuthor($result, $data);
		$this->getSubModels($result);

		if($this->dev)
			echo $sql . '<br>';

		return $result;
	}

	private function setAuthor(Array &$arr, Array &$data){

		foreach($arr as $key => $val){

			if($val['userId'] == $data['user_id'])
				$val['author'] = true;

			$arr[$key] = $this->modTempl->noteTempl($val);
		}
	}
}