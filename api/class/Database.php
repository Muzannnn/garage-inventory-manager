<?php
/**
 * Summary of Database
 */
class Database
{
	/**
	 * Summary of BDD
	 * @var 
	 */
	public $BDD;

	/**
	 * Summary of __construct
	 * @param string $mysql_host
	 * @param string $mysql_database
	 * @param string $mysql_username
	 * @param string $mysql_password
	 * @param int $mysql_port
	 */
	function __construct($mysql_host, $mysql_database, $mysql_username, $mysql_password, $mysql_port)
	{
		try {
			$this->BDD = new PDO("mysql:dbname=" . $mysql_database . ";port=" . $mysql_port . ";host=" . $mysql_host, $mysql_username, $mysql_password);
		} catch (PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}


	/**
	 * Summary of Insert
	 * @param string $table_name
	 * @param array $data
	 * @param string $filter_enable
	 * @return void
	 */
	public function Insert($table_name, $data, $filter_enable = true)
	{
		try {
			$value_push = array();

			$sql = "INSERT INTO " . $table_name;

			$key_sql = "(";
			$value_sql = "(";

			foreach ($data as $key => $value) {
				$key_sql .= $key . ",";
				$value_sql .= "?,";
				if ($filter_enable) {
					array_push($value_push, htmlentities($value));
				} else {
					array_push($value_push, $value);
				}
			}

			$key_sql = substr($key_sql, 0, -1) . ")";
			$value_sql = substr($value_sql, 0, -1) . ")";

			$sql = $sql . $key_sql . " VALUES " . $value_sql;

			$req = $this->BDD->prepare($sql);
			$req->execute($value_push);
		} catch (PDOException $e) {
			echo 'Échec lors de l\'insertion : ' . $e->getMessage();
		}
	}

	/**
	 * Summary of Delete
	 * @param string $table_name
	 * @param array $where_check
	 * @return void
	 */
	public function Delete($table_name, $where_check = array())
	{
		try {
			$value_push = array();
			$where = "";

			if (count($where_check) != 0) {
				$where = " WHERE ";
				foreach ($where_check as $key => $value) {
					$where .= $key . " = ? AND ";
					array_push($value_push, $value);
				}

				$where = substr($where, 0, -5);
			}

			$sql = "DELETE FROM " . $table_name . $where;

			$req = $this->BDD->prepare($sql);
			$req->execute($value_push);
		} catch (PDOException $e) {
			echo 'Échec lors de la suppresion : ' . $e->getMessage();
		}
	}

	/**
	 * Summary of DeleteTable
	 * @param string $table_name
	 * @return void
	 */
	public function DeleteTable($table_name)
	{
		try {
			$sql = "TRUNCATE TABLE " . $table_name;
			$this->BDD->exec($sql);
		} catch (PDOException $e) {
			echo 'Échec lors de la suppresion de la table : ' . $e->getMessage();
		}
	}

	/**
	 * Summary of GetContent
	 * @param string $table_name
	 * @param array $where_check
	 * @param string $custom
	 * @return array
	 */
	public function GetContent($table_name, $where_check = array(), $custom = "")
	{
		$value_push = array();
		$where = "";

		if (count($where_check) != 0) {
			$where = " WHERE ";
			foreach ($where_check as $key => $value) {
				$where .= $key . " = ? AND ";
				array_push($value_push, $value);
			}
			$where = substr($where, 0, -5);
		}

		$sql = "SELECT * FROM " . $table_name . $where . " " . $custom;

		$req = $this->BDD->prepare($sql);
		$req->execute($value_push);

		return $req->fetchAll();
	}

	/**
	 * Summary of Update
	 * @param string $table_name
	 * @param array $where_check
	 * @param array $data
	 * @param string $filter_enable
	 * @return void
	 */
	public function Update($table_name, $where_check, $data, $filter_enable = true)
	{
		try {
			$value_push = array();
			$where = "";

			$sql = "UPDATE " . $table_name . " SET ";

			foreach ($data as $key => $value) {
				$sql .= $key . " = ?,";
				if ($filter_enable) {
					array_push($value_push, htmlentities($value));
				} else {
					array_push($value_push, $value);
				}

			}

			if (count($where_check) != 0) {
				$where = " WHERE ";
				foreach ($where_check as $key => $value) {
					$where .= $key . " = ? AND ";
					array_push($value_push, $value);
				}

				$where = substr($where, 0, -5);
			}

			$sql = substr($sql, 0, -1);

			$sql = $sql . $where;

			$req = $this->BDD->prepare($sql);
			$req->execute($value_push);
		} catch (PDOException $e) {
			echo 'Échec lors de l\'update : ' . $e->getMessage();
		}
	}

	/**
	 * Summary of Count
	 * @param string $table_name
	 * @param array $where_check
	 * @return int
	 */
	public function Count($table_name, $where_check = array())
	{
		try {
			$value_push = array();
			$where = "";

			if (count($where_check) != 0) {
				$where = " WHERE ";
				foreach ($where_check as $key => $value) {
					$where .= $key . " = ? AND ";
					array_push($value_push, $value);
				}
				$where = substr($where, 0, -5);
			}

			$sql = "SELECT * FROM " . $table_name . $where;

			$req = $this->BDD->prepare($sql);
			$req->execute($value_push);

			return $req->rowCount();
		} catch (PDOException $e) {
			echo 'Échec lors des compte : ' . $e->getMessage();
			return 0;
		}
	}

	/**
	 * Summary of LastInsertID
	 * @return bool|string
	 */
	public function LastInsertID()
	{
		return $this->BDD->lastInsertId();
	}
}
