<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 08.02.2019
 * Time: 14:44
 */

/**
 * Class ModelTemplates
 *
 * This class is a template class for the model types which are used in frontend.
 * All the members convert the db data into the form which are used in the frontend.
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

	public function noteTempl(Array $noteArr){

		$note = array(
			'id'        => isset($noteArr['id']) ? intval($noteArr['id']) : 0,
			'name'      => isset($noteArr['name']) ? $noteArr['name'] : '',
			'text'      => isset($noteArr['noteText']) ? $noteArr['noteText'] : '',
			'userId'    => isset($noteArr['userId']) ? intval($noteArr['userId']) : 0,
			'partyId'   => isset($noteArr['partyId']) ? intval($noteArr['partyId']) : 0,
			'read'      => isset($noteArr['read']) ? $noteArr['read'] : null,
			'tags'      => isset($noteArr['tags']) ? $noteArr['tags'] : null,
			'date'      => isset($noteArr['noteDate']) ? date('d.m.Y', $noteArr['noteDate']) : '',
			'author'    => isset($noteArr['author']) ? $noteArr['author'] : false,
		);

		return $note;
	}

	public function tagTempl(Array $tagArr){

		$tag = array(
			'id'        => isset($tagArr['id']) ? intval($tagArr['id']) : 0,
			'name'      => isset($tagArr['name']) ? $tagArr['name'] : '',
			'partyId'   => isset($tagArr['partyId']) ? $tagArr['partyId'] : '',
		);

		return $tag;
	}

	public function statusTempl(Array $statusArr){

		$status = array(
			'status'    => isset($statusArr['status']) ? boolval($statusArr['status']) : false,
			'msg'       => isset($statusArr['msg']) ? $statusArr['msg'] : '',
		);

		return $status;
	}

	public function loginTempl(Array $logArr){

		$log = array(
			'token'     => isset($logArr['token']) ? $logArr['token'] : '',
			'status'    => isset($logArr['status']) ? boolval($logArr['status']) : false,
			'timestamp' => isset($logArr['timestamp']) ? intval($logArr['timestamp']) : 0,
		);

		return $log;
	}
}