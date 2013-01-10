<?php

// Doelen Data Access Object
class DoelenDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `doelen` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `doelen` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `doelen` (Omschrijving,GewijzigdDoor,GewijzigdOp) VALUES (%A,%B,'%C')";
	var $SQL_UPDATE = "UPDATE `doelen` SET ";
	var $SQL_DELETE = "DELETE FROM `doelen` WHERE DoelID=%A";

	// default constructor
	function DoelenDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single DoelenVO obeject
	function findByPK($DoelID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (DoelID='$DoelID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new DoelenVO(
				$row->DoelID, 
				$row->Omschrijving, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of DoelenVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new DoelenVO(
				$row->DoelID, 
				$row->Omschrijving, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of DoelenVO objects
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
			$vo = new DoelenVO(
				$row->DoelID, 
				$row->Omschrijving, 
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
		$this->sql = str_replace("%A", $vo->Omschrijving, $this->sql);
		$this->sql = str_replace("%B", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%C", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "Omschrijving = '" . $vo->Omschrijving . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";

		$this->sql .= "WHERE DoelID=" . $vo->DoelID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->DoelID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}



?>