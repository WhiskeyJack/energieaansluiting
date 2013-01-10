<?php

// Netbeheerders Data Access Object
class NetbeheerdersDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `netbeheerders` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `netbeheerders` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `netbeheerders` (NetBeheerderEAN,NetBeheerderNaam,NetBeheerderContactPersoon,NetBeheerderTelefoonNummer,GewijzigdDoor,GewijzigdOp) VALUES ('%A',%B,%C,%D,%E,'%F')";
	var $SQL_UPDATE = "UPDATE `netbeheerders` SET ";
	var $SQL_DELETE = "DELETE FROM `netbeheerders` WHERE NetBeheerderID=%A";

	// default constructor
	function NetbeheerdersDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single NetbeheerdersVO obeject
	function findByPK($NetBeheerderID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (NetBeheerderID='$NetBeheerderID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new NetbeheerdersVO(
				$row->NetBeheerderID, 
				$row->NetBeheerderEAN, 
				$row->NetBeheerderNaam, 
				$row->NetBeheerderContactPersoon, 
				$row->NetBeheerderTelefoonNummer, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of NetbeheerdersVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new NetbeheerdersVO(
				$row->NetBeheerderID, 
				$row->NetBeheerderEAN, 
				$row->NetBeheerderNaam, 
				$row->NetBeheerderContactPersoon, 
				$row->NetBeheerderTelefoonNummer, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of NetbeheerdersVO objects
	// value for $where is some thing like "(xxx = 'abc') AND (zzz='123')"
	// value for $order_by is a comma separated list of columns "company, name"
	function findWhere($where = "", $orderby = "") {
		$this->sql = $this->SQL_SELECT;
		$voList = array();
		if(strlen($where) > 0 ) {
			$where = "WHERE (" . $where . ") ";
		}
		if(strlen($orderby) > 0) {
			$orderby = "ORDER BY " . $orderby;
		} else {
			$orderby = "ORDER BY 1";
		}
		$this->sql .= $where . " " . $orderby;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new NetbeheerdersVO(
				$row->NetBeheerderID, 
				$row->NetBeheerderEAN, 
				$row->NetBeheerderNaam, 
				$row->NetBeheerderContactPersoon, 
				$row->NetBeheerderTelefoonNummer, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// insert a record from a vo
	function insertVO($vo) {
		$this->sql = $this->SQL_INSERT;
		$this->sql = str_replace("%A", $vo->NetBeheerderEAN, $this->sql);
		$this->sql = str_replace("%B", $vo->NetBeheerderNaam, $this->sql);
		$this->sql = str_replace("%C", $vo->NetBeheerderContactPersoon, $this->sql);
		$this->sql = str_replace("%D", $vo->NetBeheerderTelefoonNummer, $this->sql);
		$this->sql = str_replace("%E", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%F", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "NetBeheerderEAN = '" . $vo->NetBeheerderEAN . "', ";
		$this->sql .= "NetBeheerderNaam = '" . $vo->NetBeheerderNaam . "', ";
		$this->sql .= "NetBeheerderContactPersoon = '" . $vo->NetBeheerderContactPersoon . "', ";
		$this->sql .= "NetBeheerderTelefoonNummer = '" . $vo->NetBeheerderTelefoonNummer . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";

		$this->sql .= "WHERE NetBeheerderID=" . $vo->NetBeheerderID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->NetBeheerderID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}

?>