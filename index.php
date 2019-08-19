<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 25.01.2019
 * Time: 19:09
 */

$dir = './modules/';

require_once ('./security/security.php');
require_once ('modelTemplates/modelTemplates.php');
require_once ($dir . 'navigation/navigation.php');
require_once ($dir . 'worlds/worlds.php');
require_once ($dir . 'parties/parties.php');
require_once ($dir . 'notes/notes.php');
require_once ($dir . 'tags/tags.php');
require_once ($dir . 'account/account.php');


header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header('authorization: Bearer xx.yy.zz');

class Router
{

	public function __construct()
	{

		$module         = $_GET['module'];
		$action         = $_GET['action'];
		$data           = $_GET['data'];

		$dev            = $_GET['dev'] ? $_GET['dev'] : false;

		$result         = null;

		if($check && strlen($data['token']) < 5 ){

			if($dev)
				echo 'no response check <br>';

			$this->returnData(null);
			die();
		}

		$temp = array();

		$sec = new Security();
		$temp = $sec->dbAction($data);

		if($temp['user_id'])
			$data['user_id'] = $temp['user_id'];

		switch($module){

			case 'navigation':
				$navigation = new Navigation();
				$result = $navigation->dbAction($action, $data);
				break;
			case 'worlds':
				$worlds = new Worlds();
				$result = $worlds->dbAction($action, $data);
				break;
			case 'parties':
				$parties    = new Parties();
				$result     = $parties->dbAction($action, $data);
				break;
			case 'notes':
				$notes  = new Notes();
				$result = $notes->dbAction($action, $data);
				break;
			case 'tags':
				$tags   = new Tags();
				$result = $tags->dbAction($action, $data);
				break;
			case 'account':
				$acc    = new Account();
				$result = $acc->dbAction($action, $data, $dev);
				break;
		}

		if($dev){

			$this->devReturnData($result);
			die();
		}
		else{

			$this->returnData($result);
		}
	}

	/**
	 * Wandelt die Daten zu JSON und gibt sie an das Frontend zurück
	 *
	 * @param $res
	 */
	private function returnData($res){

		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($res);
	}

	private function devReturnData($res){

		echo '<p>';
		var_export($res);
		echo '</p>';
	}
}

new Router();