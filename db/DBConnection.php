<?php
/**
 * Created by PhpStorm.
 * User: dianafechner
 * Date: 02.02.2019
 * Time: 21:48
 */

class DBConnection
{

	private $host       = 'localhost';
	private $user       = 'user';
	private $pw         = '9GothiC9';
	private $dbName     = 'pnpboardbackend';

	public $db;

	public function __construct()
	{

		$this->db = new mysqli($this->host, $this->user, $this->pw, $this->dbName);

		if($this->db->connect_error)
			die("Connection failed: " . $this->db->connect_error);
	}

	/**
	 * Diese Funktion nimmt ein Mysqli Objekt entgegen und schreibt die darin enthaltenen Daten
	 * in ein Array und gibt dieses zurück
	 *
	 * @param $mysqli
	 * @return array
	 */
	public function mysqliToData($mysqli){

		$result = array();

		if($mysqli){

			while($tmp = $mysqli->fetch_array(MYSQLI_ASSOC)){

				$result[] = $tmp;
			}
		}
		else{

			$result['status'] = false;
		}

		return $result;
	}
}