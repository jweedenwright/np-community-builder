<?php
//////////////////////
// Class for handling DB Connections
//////////////////////
class pdo_dblib_mssql {
	private $db;
	private $cTransID;
	private $childTrans = array();

	public function __construct() {
		if($_SERVER['SERVER_NAME'] == $GLOBALS['prod_domain']) {
			// Prod
			$GLOBALS['current_domain'] = $GLOBALS['prod_domain'];
			$GLOBALS['current_protocol'] = $GLOBALS['prod_protocol'];
			$this->hostname = $GLOBALS['prod_db_hostname'];
			$this->dbname = $GLOBALS['prod_db_name'];
			$this->username = $GLOBALS['prod_db_user'];
			$this->port = $GLOBALS['prod_db_port'];
			$this->pwd = $GLOBALS['prod_db_password'];
		} else if($_SERVER['SERVER_NAME'] == $GLOBALS['qa_domain']) {
			// QA
			$GLOBALS['current_domain'] = $GLOBALS['qa_domain'];
			$GLOBALS['current_protocol'] = $GLOBALS['qa_protocol'];
			$this->hostname = $GLOBALS['qa_db_hostname'];
			$this->dbname = $GLOBALS['qa_db_name'];
			$this->username = $GLOBALS['qa_db_user'];
			$this->port = $GLOBALS['qa_db_port'];
			$this->pwd = $GLOBALS['qa_db_password'];
		} else {
			// Dev (default)
			$GLOBALS['current_domain'] = $GLOBALS['dev_domain'];
			$GLOBALS['current_protocol'] = $GLOBALS['dev_protocol'];
			$this->hostname = $GLOBALS['dev_db_hostname'];
			$this->dbname = $GLOBALS['dev_db_name'];
			$this->username = $GLOBALS['dev_db_user'];
			$this->port = $GLOBALS['dev_db_port'];
			$this->pwd = $GLOBALS['dev_db_password'];
		}
		$this->connect();
	}

	public function beginTransaction() {
		$cAlphanum = "AaBbCc0Dd1EeF2fG3gH4hI5iJ6jK7kLlM8mN9nOoPpQqRrSsTtUuVvWwXxYyZz";
		$this->cTransID = "T".substr(str_shuffle($cAlphanum), 0, 7);
		array_unshift($this->childTrans, $this->cTransID);
		$stmt = $this->db->prepare("BEGIN TRAN [$this->cTransID];");
		return $stmt->execute();
	}

	public function rollBack() {
		while(count($this->childTrans) > 0) {
			$cTmp = array_shift($this->childTrans);
			$stmt = $this->db->prepare("ROLLBACK TRAN [$cTmp];");
			$stmt->execute();
		}
		return $stmt;
	}

	public function commit() {
		while(count($this->childTrans) > 0){
			$cTmp = array_shift($this->childTrans);
			$stmt = $this->db->prepare("COMMIT TRAN [$cTmp];");
			$stmt->execute();
		}
		return  $stmt;
	}

	public function close() {
		$this->db = null;
	}
	
	public function connect() {
		try {
			$this->db = new PDO ("sqlsrv:Server=$this->hostname,$this->port;Database=$this->dbname", "$this->username", "$this->pwd");
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		}
	}
	
	public function executeStatement($query, $values) {
		$stmt = $this->db->prepare($query);
		if(sizeOf($values) == 0) {
			$stmt->execute();
		} else {
			$stmt->execute($values);
		}
		if (strpos($query, 'INSERT') !== false) {
			$stmt = $this->db->lastInsertId();
		}
		return $stmt;
	}
}
?>