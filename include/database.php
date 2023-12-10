<?php
/**
 * This class used to connect and manage database.
 */
class Database extends PDO{
	function __construct(){
		try {
			parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
		} catch(PDOException $e){
			echo $e;
		}
	}
	/**
	 * Select Data From database
	 * @param string $name
	 * @param array $data
	 * @param PDO::FETCH_ASSOC $fetchStyle
	 * @return array
	 */
	public function select($sql, $data = array(), $fetchStyle = PDO::FETCH_ASSOC){
		$stmt = $this->prepare($sql);
		foreach ($data as $key => $value) {
			$stmt->bindParam($key,$value);
		}
		$stmt->execute();
		return $stmt->fetchAll($fetchStyle);
	}

	/**
	 * Insert data into table
	 * @param string $table
	 * @param array $data
	 * @return bool
	 */
	public function insert($table, $data){
		ksort($data);
		$fieldNames = implode(',', array_keys($data));
		$fieldValues = ':'.implode(', :', array_keys($data));

		$stmt = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

		foreach($data as $key => $value){
			$stmt->bindValue(":$key", $value);
		}
		return $stmt->execute();		
	}

	/**
	 * Update data to database
	 * @param string $table
	 * @param array $data
	 * @param string $where
	 * @return bool
	 */
	public function update($table, $data, $where){
        $updateKeys = NULL;
	 	foreach ($data as $key => $value) {
	 		$updateKeys .= "$key=:$key,";
	 	}
	 	$updateKeys = rtrim($updateKeys, ",");
	 	$sql = "UPDATE $table SET $updateKeys WHERE $where";
	 	$stmt = $this->prepare($sql);
	 	foreach ($data as $key => $value) {
	 		$stmt->bindValue(":$key", $value);
	 	}
	 	return $stmt->execute();
	}

	/**
	 * Execute sql raw query
	 * @param string $sql
	 * @return bool
	 */
	public function extra_query($sql){
	 	$stmt = $this->prepare($sql);
	 	return $stmt->execute();
	}

	/**
	 * Delete data from database
	 * @param string $table
	 * @param string $where
	 * @return PDO::exec()
	 */
	public function delete($table, $where){
		$sql = "DELETE FROM $table WHERE $where";
        return $this->exec($sql);
	}
}
