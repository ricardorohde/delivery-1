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
	public static function find($table_where_select, $query = '', $execute_params = array()) {
		$sql = self::connect();
		$sql = $sql->prepare("SELECT * FROM `$table_where_select` $query");
		$sql->execute($execute_params);
		return $sql->fetch();
	}
	public static function selectAll($table_where_select, $query, $execute_params) {
		$sql = self::connect();
		$sql = $sql->prepare("SELECT * FROM `$table_where_select` $query");
		$sql->execute($execute_params);
		return $sql->fetchAll();
	}
	public static function update($table_where_update, $query, $execute_params) {
		$sql = self::connect();
		$sql = $sql->prepare("UPDATE `$table_where_update` $query");
		$sql->execute($execute_params);
	}
	public static function insert($table_where_insert, array $execute_params) {
		$sql = self::connect();
		$query = "INSERT INTO `$table_where_insert` VALUES(null,";
		$params_iterator = count($execute_params) - 1; /*This -1 is to prevent all parameters from being passed and a comma at the end, HAVING CONTROL OVER THE LAST CHARACTER. Example:
		$params_iterator = 5;

		the for goes through all the positions, putting commas at the end. If this happens, we will have a query like this:

		-> "INSERT INTO `$table_where_insert` VALUES (null,?,?,?,?,?,) "

		This would give an error, so we decrement the iterator to have control over the last parameter of the query

		*/
		for($i = 0; $i < $params_iterator; $i++) {
			$query.='?,';
		}
		$query.='?)';
		$sql = $sql->prepare($query);
		$sql->execute($execute_params);
	}
	public static function delete($table_where_delete, $query, $execute_params) {
		$sql = self::connect();
		$sql = $sql->prepare("DELETE FROM `$table_where_delete` $query");
		$sql->execute($execute_params);
	}
}
?>