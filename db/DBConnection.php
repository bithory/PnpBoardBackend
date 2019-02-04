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

	/**
	 * Hier wird nach unterstrichen für die Datnbankdeklaration (des Spaltennamens) gesucht.
	 * Wenn ein Unterstrich gefunden wird dann wird dieser entfernt und die beiden Wörter in CamalCase
	 * zusammengefügt.
	 *
	 * @param array $arr
	 */
	public function convertKey(Array &$arr){

		if(isset($arr)){

			foreach($arr as $key => $val){

				foreach($val as $key1 => $val1){

					if(strpos($key1, '_') !== false){

						$pos = strpos($key1, '_');

						$strStart   = substr($key1, 0, $pos);
						$strEnd     = substr($key1, $pos + 1);

						$newKey     = $strStart . ucfirst($strEnd);

						$arr[$key][$newKey] = $val1;

						unset($arr[$key][$key1]);
					}
				}
			}
		}
	}
}