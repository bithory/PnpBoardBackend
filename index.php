<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 25.01.2019
 * Time: 19:09
 */


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

class Router
{

	public function __construct()
	{

//		$test = array();
//
//		$test['status'] = 'HTTP OK';
//		$test['text']   = 'and this is an example text';
//
//		echo json_encode($test);

		$module         = $_GET['module'];
		$action         = $_GET['action'];
		$data           = $_GET['data'];

		$result         = null;

		$dir = './modules/';

		switch($module){

			case 'navigation':
				require_once ($dir . 'navigation/navigation.php');
				$navigation = new Navigation();
				$result = $navigation->dbAction($action, $data);
				break;
			case 'worlds':
				require_once ($dir . 'worlds/worlds.php');
				$worlds = new Worlds();
				$result = $worlds->dbAction($action, $data);
				break;
			case 'parties':
				require_once ($dir . 'parties/parties.php');
				$parties    = new Parties();
				$result     = $parties->dbAction($action, $data);
				break;
			case 'notes':
				require_once ($dir . 'notes/notes.php');
				$notes  = new Notes();
				$result = $notes->dbAction($action, $data);
		}

		$this->returnData($result);
	}

	private function returnData($res){

//		$test = array();
//
//		$test['status'] = 'HTTP OK';
//		$test['text']   = 'and this is an example text';

//		echo var_dump($res);
		echo json_encode($res);
	}
}

new Router();