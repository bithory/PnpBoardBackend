<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 08.02.2019
 * Time: 14:44
 */

class ModelTemplates
{

	public function __construct(){	}

	public function userTempl(Array $usrArr){

		$user = array(
			'id'        => isset($usrArr['id']) ? intval($usrArr['id']) : 0,
			'username'  => isset($usrArr['username']) ? $usrArr['username'] : '',
			'pw'        => isset($usrArr['pw']) ? $usrArr['pw'] : '',
			'email'     => isset($usrArr['email']) ? $usrArr['email'] : '',
		);

		return $user;
	}

	public function worldTempl(Array $worldArr){

		$world = array(
			'id'        => isset($worldArr['id']) ? intval($worldArr['id']) : 0,
			'name'      => isset($worldArr['name']) ? $worldArr['name'] : '',
			'short'     => isset($worldArr['short']) ? $worldArr['short'] : '',
			'desc'      => isset($worldArr['description']) ? $worldArr['description'] : '',
			'edition'   => isset($worldArr['edition']) ? $worldArr['edition'] : '',
			'author'    => isset($worldArr['author']) ? intval($worldArr['author']) : 0,
		);

		return $world;
	}

	public function partyTempl(Array $partyArr){

		$party = array(
			'id'        => isset($partyArr['id']) ? intval($partyArr['id']) : 0,
			'name'      => isset($partyArr['name']) ? $partyArr['name'] : '',
			'world'     => isset($partyArr['world']) ? $partyArr['world'] : null,
			'sheet'     => isset($partyArr['gm']) ? $partyArr['gm'] : null,
			'sheet'     => isset($partyArr['sheet']) ? $partyArr['sheet'] : null,
		);

		return $party;
	}

	public function sheetTempl(Array $sheetArr){

		$sheet = array(
			'id'        => isset($sheetArr['id']) ? intval($sheetArr['id']) : 0,
			'name'      => isset($sheetArr['name']) ? $sheetArr['name'] : '',
			'worldId'   => isset($sheetArr['worldId']) ? intval($sheetArr['worldId']) : 0,
		);

		return $sheet;
	}
}