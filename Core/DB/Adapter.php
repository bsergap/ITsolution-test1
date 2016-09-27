<?php
namespace Core\DB;
//////////////////////////////////////////////////
class Adapter {
	private static $mysqli;
	private static function init() {
		if((static::$mysqli = mysqli_connect()) === false)
			throw new \Exception('Connection to the database is not initialized!');
	}
	static function connect($dbname) {
		if(empty(static::$mysqli)) static::init();
		if(!static::$mysqli->select_db($dbname))
			throw new \Exception('Could not select a db!');
		return static::$mysqli;
	}

	static function escape($string) {
		return static::$mysqli->escape_string($string);
	}
	static function runQuery($query) {
		return static::$mysqli->query($query);
	}

	static function getInsertID($query) {
		if(!$result = static::$mysqli->query($query))
			throw new \Exception('Could not insert the value!');
		return static::$mysqli->insert_id;
	}
	static function getOneValue($query) {
		if(!$result = static::$mysqli->query($query))
			throw new \Exception('Could not get a single value!');
		return $result->fetch_row()[0];
	}
	static function getObjecRow($query) {
		if(!$result = static::$mysqli->query($query))
			throw new \Exception('Could not get the row object!');
		return $result->fetch_object();
	}
}
