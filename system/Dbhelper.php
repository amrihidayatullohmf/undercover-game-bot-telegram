<?php
define('RETURN_OBJ','object');
define('RETURN_ARR','array');

class Dbhelper {
	private $con;

	function __construct($configs) {
		$this->con = mysqli_connect(
					$configs['dbhost'],
					$configs['dbuser'],
					$configs['dbpassword'],
					$configs['dbname']
				);

		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}

	public function update($table_name,$datas = [],$where = []) {
		if(count($datas) == 0) {
			return FALSE;
		}

		$column_name = [];

		foreach ($datas as $key => $value) {
			$column_name[] = " ".$key." = '".$value."' ";
		}

		$column_where = [];

		foreach ($where as $key => $value) {
			$column_where[] = " ".$key." = '".$value."' ";
		}


		$query = "UPDATE ".$table_name." SET ".implode(",", $column_name)." WHERE ".implode("AND", $column_where);
		return mysqli_query($this->con,$query);
	}

	public function insert($table_name,$datas = []) {
		if(count($datas) == 0) {
			return FALSE;
		}

		$column_name = [];
		$column_value = [];

		foreach ($datas as $key => $value) {
			$column_name[] = $key;
			$column_value[] = "'".$value."'";
		}

		$query = "INSERT INTO ".$table_name." (".implode(",", $column_name).") VALUES (".implode(",", $column_value).")";
		return mysqli_query($this->con,$query);
	}

	public function get_where($table_name,$where = [],$order_by = [], $limit = [],$row_only = FALSE) {
		$query = "SELECT * FROM ".$table_name." ";

		if(count($where)) {
			$where_arr = [];
			foreach ($where as $key => $value) {
				$where_arr[] = " ".$key." = '".$value."' ";
			}
			$query .= " WHERE ".implode("AND", $where_arr)." ";
		}

		if(count($order_by)) {
			$order_arr = [];
			foreach ($order_by as $key => $value) {
				$order_arr[] = " ".$key." ".$value." ";
			}
			$query .= " ORDER BY ".implode(",", $order_arr)." ";
		}

		if(count($limit) > 1) {
			$query .= " LIMIT ".$limit[0].",".$limit[1];
		}

		$datas = mysqli_query($this->con,$query);
		$rows = [];

		while($row = mysqli_fetch_array($datas,MYSQLI_ASSOC)) {
			$rows[] = $row;
		}

		return ($row_only) ? end($rows) : $rows;
	}

	public function query($query) {
		$datas = mysqli_query($this->con,$query);
		$rows = [];

		while($row = mysqli_fetch_array($datas,MYSQLI_ASSOC)) {
			$rows[] = $row;
		}

		return $rows;
	}
}

$dbhelper = new Dbhelper($configs);
