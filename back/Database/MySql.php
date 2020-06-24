<?php
namespace Database;
class MySql {
	private static $pdo;
	public static function connect() {
		try {
		self::$pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
		self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		self::$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES,TRUE);
		return self::$pdo;
		} catch(Exception $e) {
			echo 'Error while connecting with database! Try again later...';
		}

	}
	public static function selectAll($table) {
		$sql = self::connect();
		$query = "SELECT * FROM `".$table.'`';
		$sql = $sql->prepare($query);
		$sql->execute();
		return $sql->fetchAll();
	}
	public static function select($table, $query, $params) {
		$sql = self::connect();
		$sql = $sql->prepare("SELECT * FROM `$table` $query");
		$sql->execute($params);
		return $sql->fetchAll();
	}
	public static function update($table, $query, $params) {
		$sql = self::connect();
		$sql = $sql->prepare("UPDATE `$table` $query");
		$sql->execute($params);
	}
	public static function insert($table, array $params) {
		$sql = self::connect();
		$query = "INSERT INTO `$table` VALUES(null,";
		$count = count($params) - 1;
		for($i = 0; $i < $count; $i++) {
			$query.='?,';
		}
		$query.='?)';
		$sql = $sql->prepare($query);
		$sql->execute($params);
	}
	public static function delete($table, $query, $params) {
		$sql = self::connect();
		$sql = $sql->prepare("DELETE FROM `$table` $query");
		$sql->execute($params);
	}
}
?>