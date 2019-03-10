<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 27.02.2019
 * Time: 00:51
 */

require_once('./db/DBConnection.php');
require_once('./modelTemplates/modelTemplates.php');

abstract class ModulInterface
{

	/**
	 * @var DBConnection
	 */
	protected $dbConn;

	/**
	 * @var ModelTemplates
	 */
	protected $modTempl;

	public function __construct()
	{

		$this->dbConn   = new DBConnection();
		$this->modTempl = new ModelTemplates();
	}

	public function dbAction(&$action, &$data){

		$result = array();

		switch($action){

			case 'index':
				$result = self::getIndex($data);
				break;
			case 'load':
				$result = self::load($data);
				break;
			case 'add':
				$result = self::add($data);
				break;
			case 'edit':
				$result = self::edit($data);
				break;
			case 'delete':
				$result = self::delete($data);
				break;
			default:    //laden der Templates
				require_once ('./modules/parties/dataLists.php');
				$template   = new DataLists($this->dbConn);
				$result     = $template->dbAction($action, $data);
				break;
		}

		self::$dbConn->db->close();

		return $result;
	}

	 protected function getIndex(&$data){}

	 protected function load(&$data){}

	 protected function add(&$data){}

	 protected function edit(&$data){}

	 protected function delete(&$data){}
}